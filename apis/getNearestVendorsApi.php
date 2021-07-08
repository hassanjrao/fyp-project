<?php



ob_start();
include('../includes/db.php');


$response = array();

if (isTheseParametersAvailable(array("lat", "lng"))) {


    $lat = $_GET["lat"];
    $lng = $_GET["lng"];

  
    try {
       

        $query = $conn->prepare(
            "SELECT * , (3956 * 2 * ASIN(SQRT( POWER(SIN(( $lat - lat) *  pi()/180 / 2), 2) +COS( $lat * pi()/180) * COS(lat * pi()/180) * POWER(SIN(( $lng - lng) * pi()/180 / 2), 2) ))) as distance  
            from users
          
            having  distance <= 20 and role=2
        
          
            order by distance"
        );
    


        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_OBJ);


        $response['error'] = false;
        $response["status"] = "success";
        $response['message'] = 'Fetched Successfully';
        $response['result'] = $result;
    } catch (PDOException $e) {


        $response['error'] = true;
        $response["status"] = "fail";
        $response['message'] = $e->getMessage();;
    }
} else {
    $response['error'] = true;
    $response["status"] = "fail";
    $response['message'] = 'required parameters are not available';
}

echo json_encode($response);


function isTheseParametersAvailable($params) //method to check whther the varaibles which we recieved from POST request have values or not.
{

    foreach ($params as $param) {
        if (!isset($_GET[$param])) {
            return false;
        }
    }
    return true;
}
