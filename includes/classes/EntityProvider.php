<?php
class EntityProvider{

    public static function getEntities($con, $categoryId, $limit){

        $sql = "SELECT * FROM entities "; // must have a space at the end

        if ($categoryId != null){
            $sql .= "WHERE categoryId=:categoryId "; // must have a space at the end
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId != null){
            $query->bindValue(":categoryId",$categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($con, $row);
        }

        return $result;
    }

    public static function getTVShowEntities($con, $categoryId, $limit){

        $sql = "SELECT DISTINCT(entities.id) FROM entities
                INNER JOIN videos ON entities.id = videos.entityId
                WHERE videos.isMovie = 0 "; // must have a space at the end

        if ($categoryId != null){
            $sql .= "AND categoryId=:categoryId "; // must have a space at the end
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId != null){
            $query->bindValue(":categoryId",$categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($con, $row["id"]);
        }

        return $result;
    }

    public static function getMoviesEntities($con, $categoryId, $limit){

        $sql = "SELECT DISTINCT(entities.id) FROM entities
                INNER JOIN videos ON entities.id = videos.entityId
                WHERE videos.isMovie = 1 "; // must have a space at the end

        if ($categoryId != null){
            $sql .= "AND categoryId=:categoryId "; // must have a space at the end
        }

        $sql .= "ORDER BY RAND() LIMIT :limit";

        $query = $con->prepare($sql);

        if($categoryId != null){
            $query->bindValue(":categoryId",$categoryId);
        }

        $query->bindValue(":limit", $limit, PDO::PARAM_INT);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($con, $row["id"]);
        }

        return $result;
    }

    public static function getSearchEntities($con, $term){

        $sql = "SELECT * FROM entities WHERE name LIKE CONCAT('%', :term, '%') LIMIT 30";
        
        $query = $con->prepare($sql);

        $query->bindValue(":term", $term);
        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $result[] = new Entity($con, $row);
        }

        return $result;
    }
}

?>