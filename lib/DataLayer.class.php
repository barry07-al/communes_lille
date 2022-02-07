<?php
class DataLayer {
	// private ?PDO $conn = NULL; // le typage des attributs est valide uniquement pour PHP>=7.4

	private  $connexion = NULL; // connexion de type PDO   compat PHP<=7.3
	
	/**
	 * @param $DSNFileName : file containing DSN 
	 */
	function __construct(string $DSNFileName){
		$dsn = "uri:$DSNFileName";
		$this->connexion = new PDO($dsn);
		// paramètres de fonctionnement de PDO :
		$this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // déclenchement d'exception en cas d'erreur
		$this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC); // fetch renvoie une table associative
		// réglage d'un schéma par défaut :
		$this->connexion->query('set search_path=communes_mel, authent');
	}
    
	/**
	 * Liste des territoires
	 * @return array tableau de territoires
	 * chaque territoire comporte les clés :
		* id (identifiant, entier positif),
		* nom (chaîne),
		* min_lat (latitude minimale, flottant),
		* min_lon (longitude minimale, flottant),
		* max_lat, max_lon
	 */
	function getTerritoires(): array {
		$sql = "select id, nom , min_lat, min_lon, max_lat, max_lon from territoires join bb_territoires on id=territoire";
		$stmt = $this->connexion->prepare($sql);
		$stmt->execute();
		$res= $stmt->fetchAll();
		return $res;
	}
	
	/**
	 * Liste de communes correspondant à certains critères
	 * @param territoire : territoire des communes cherchées
	 * @return array tableau de communes (info simples)
	 * chaque commune comporte les clés :
		* insee (chaîne),
		* nom (chaîne),
		* lat, lon 
		* min_lat (latitude minimale, flottant),
		* min_lon (longitude minimale, flottant),
		* max_lat, max_lon
	 */
	function getCommunes(?int $territoire=NULL, ?string $nom=NULL, ?float $surface=NULL, ?int $pop_totale=NULL): array {
		$sql = <<<EOD
		select insee, nom, lat, lon, min_lat, min_lon, max_lat, max_lon, pop_totale, territoire, surface
		from communes_mel.communes natural join bb_communes natural left join 
		(select * from population where (recensement = 2016 or recensement is null) ) as pop
EOD;

		$conds = [];  // tableau contenant les code SQL de chaque condition à appliquer
		$binds = [];   // association entre le nom de pseudo-variable et sa valeur
		if($territoire !== NULL){
            $conds[] = "territoire = :territoire" ;
            $binds[':territoire'] = $territoire ;
        }
        if($nom !== NULL){
            $conds[] = "UPPER(nom) LIKE UPPER('%$nom%')";
        }
        if($surface !== NULL){
            $conds[] = "surface > :surface";
            $binds[':surface'] = $surface*(10**4);
        }
        if($pop_totale !== NULL){
			$conds[] = "pop_totale >= :pop" ;
			$binds[':pop'] = $pop_totale ;
        }
		if(count($conds)>0){ // il ya au moins une condition à appliquer ---> ajout d'ue clause where
			$sql .= " where ". implode(' and ', $conds) ; // les conditions sont reliées par AND
		}
		$stmt = $this->connexion->prepare($sql);
		$stmt->execute($binds);
		return $stmt->fetchAll() ;
	}
	
	
	/**
	 * Information détaillée sur une commune
	 * @param insee : code insee de la commune
	 * @return commune ou NULL si commune inexistante
	 * l'objet commune comporte les clés :
	 *	insee, nom, nom_terr, surface, perimetre, pop2016, lat, lon, geo_shape
	 */
	function getDetails(string $insee): ?array { 
		$sql = <<<EOD
			select insee, communes.nom, territoires.nom as nom_terr, surface, perimetre, population.pop_totale as pop2016,
			lat, lon, geo_shape   from communes 
			join communes_mel.territoires on id=territoire
			natural left join communes_mel.population
			where (recensement=2016 or recensement is null) and insee=:insee
EOD;
		$stmt = $this->connexion->prepare($sql);
		$stmt->execute([':insee'=>$insee]);
		$res= $stmt->fetch() ;
		return $res ? $res : NULL;
	}


	/**
    * @return bool indiquant si l'ajout a été réalisé
    */
    function createUser(string $login, string $password, string $nom, string $prenom) : bool {
		$sql = <<<EOD
		insert into "users" (login, password, nom, prenom) values (:login, :password, :nom, :prenom)
EOD;
        try{ 
        $stmt = $this->connexion->prepare($sql) ;
        $stmt->bindValue(':login',$login) ;
        $stmt->bindValue(':password',password_hash($password,CRYPT_BLOWFISH)) ;
        $stmt->bindValue(':nom',$nom) ;
        $stmt->bindValue(':prenom',$prenom) ;
        $stmt->execute();
        return TRUE ;
        }
        catch(PDOException $e){
            return FALSE ;
        }
        
    }




	function authentification(string $login, string $password) : ?array{ 
        $sql = <<<EOD
        select login,password,nom,prenom from users where login=:login
EOD;
        $stmt = $this->connexion->prepare($sql) ;
        $stmt->bindValue(':login',$login) ;
        $stmt->execute() ;
        $res = $stmt->fetch() ;
        $pass_crypte = crypt($password,$res['password']) ;

        if ($res['login']===$login && $res['password']===$pass_crypte) {
            $result = ['login'=>$res['login'], 'nom'=>$res['nom'], 'prenom'=>$res['prenom']] ;
        }
        else{
            $result = NULL ;
		}
		
		return $result ;
	}

	function addFavori(string $login, string $insee) : ?string{

		$sql = <<<EOD
		insert into "favoris" (insee, login) VALUES (:insee, :login)
EOD;
		
		try{
			$stmt = $this->connexion->prepare($sql) ;
			$stmt->bindValue(':login',$login) ;
			$stmt->bindValue(':insee',$insee) ;
			$stmt->execute() ;
			return  $insee;
		}
		catch(PDOException $e){
			return NULL ;
		}
	}

	function removeFavori(string $login, string $insee) : ?string{

		$sql = <<<EOD
		delete from "favoris" where login=:login and insee=:insee
EOD;
		try{
			$stmt = $this->connexion->prepare($sql) ;
			$stmt->bindValue(':login',$login) ;
			$stmt->bindValue(':insee',$insee) ;
			$stmt->execute() ;
			return $insee ;
		}
		catch(PDOException $e){
			return NULL ;
		}
	}

	function getFavoris($login) : ?array{

		$sql = <<<EOD
		select nom, lat, lon, min_lat, min_lon, max_lat, max_lon, "favoris".insee 
		from authent.favoris join communes_mel.communes on "favoris".insee=communes.insee 
		join bb_communes on bb_communes.insee = "favoris".insee  where login=:login
EOD;
		try {
			$stmt = $this->connexion->prepare($sql);
			$stmt->bindValue(':login',$login) ;
			$stmt->execute() ;
			return $stmt->fetchAll() ;
		}
		catch(PDOException $e){
			return NULL ;
		}
	}
		
}
?>