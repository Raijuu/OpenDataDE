<?php


       //$service_url = 'https://data.delaware.gov/resource/f6a3-crpj.json';
       //$curl = curl_init($service_url);
       //curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       //curl_setopt($curl, CURLOPT_POST, true);
       //$curl_response = curl_exec($curl);
       //curl_close($curl);

       //$jsonObject = jsondecode($curl_response);



       //next example will recieve all messages for specific conversation
       $service_url = 'https://data.delaware.gov/resource/f6a3-crpj.json';
       $curl = curl_init($service_url);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       $curl_response = curl_exec($curl);
       
       if ($curl_response === false) {
         $info = curl_getinfo($curl);
         curl_close($curl);
         die('error occured during curl exec. Additional info: ' . var_export($info));
       }
       curl_close($curl);
       
       $decoded = json_decode($curl_response);
       if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
         die('error occured: ' . $decoded->response->errormessage);
       }
       echo 'response ok!';


  //     print_r($decoded[0]);

//exit(0);
       //************sqlite3
       
       date_default_timezone_set('UTC');

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('OpenDataDE.db');
    }
}

 $schoolyear = $decoded[0]->schoolyear;
 $districtcode = $decoded[0]->districtcode;
 $schoolcode = $decoded[0]->schoolcode;
 $districtname = $decoded[0]->districtname;
 $districttype = $decoded[0]->districttype;
 $schoolname = $decoded[0]->schoolname;
 $schooltype = $decoded[0]->schooltype;
 $street1 = $decoded[0]->street1;
 $street2 = $decoded[0]->street2;
 $city = $decoded[0]->city;
 $state = $decoded[0]->state;
 $zip = $decoded[0]->zip;
 $county = $decoded[0]->county;
 $lowestgrade = $decoded[0]->lowestgrade;
 $highestgrade = $decoded[0]->highestgrade;
 $educationlevel = $decoded[0]->educationlevel;
 $hasec = $decoded[0]->hasec;
 $haspk = $decoded[0]->haspk;
 $haskn = $decoded[0]->haskn;
 $haselementarygrade = $decoded[0]->haselementarygrade;
 $hasmiddlegrade = $decoded[0]->hasmiddlegrade;
 $hashighgrade = $decoded[0]->hashighgrade;
 $isungraded = $decoded[0]->isungraded;
 $geocodedlocation = $decoded[0]->geocoded_location_address + $decoded[0]->geocoded_location_city + $decoded[0]->geocoded_location_state + $decoded[0]->geocoded_location_zip;

 $insert = "REPLACE INTO import_school_directory (SchoolYear, DistrictCode, SchoolCode, DistrictName, DistrictType, SchoolName, SchoolType, Street1, Street2, City, State, Zip, County, LowestGrade, HighestGrade, EducationLevel, HasEC, HasPK, HasKN, HasELementaryGrade, HasMiddleGrade, HasHighGrade, IsUngraded, GeocodedLocation ) VALUES ($schoolyear, $districtcode, $schoolcode, $districtname, $schooltype, $street1, $street2, $city, $state, $zip, $county, $lowestgrade, $highestgrade, $educationlevel, $hasec, $haspk, $haskn, $haselementarygrade, $hasmiddlegrade, $hashighgrade, $isungraded, $geocodedlocation) "; 


  try {

    $db = new MyDB();

    print_r($insert);
    //$db->exec('CREATE TABLE foo (bar STRING)');
    $db->exec($insert);

    $result = $db->query('SELECT * from import_school_directory');
    
    var_dump($result->fetchArray());

  }
  catch(PDOException $e) {
    echo $e->getMessage();
  }



  exit(0);

  try {
    $file_db = new PDO('./OpenDataDE.db') or die("cannot open database");
    
    $file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $insert = "REPLACE INTO import_school_directory (SchoolYear, DistrictCode, SchoolCode, DistrictName, DistrictType, SchoolName, SchoolType, Street1, Street2, City, State, Zip, County, LowestGrade, HighestGrade, EducationLevel, HasEC, HasPK, HasKN, HasELementaryGrade, HasMiddleGrade, HasHighGrade, IsUngraded, GeocodedLocation )  VALUES (:schoolyear, :districtcode, :schoolcode, :districtname, :districttype, :schoolname, :schooltype, street1, :street2, :city, :state, :zip, :county, :lowestgrade, :highestgrade, :educationlevel, :hasec, :haspk, :haskn, :haselementarygrade, :hasmiddlegrade, :hashighgrade, :isungraded, :geocodedlocation) ";

    $stmt = $file_db->prepare($insert);

    $stmt->bindParam(':schoolyear', $decoded[0]->schoolyear);
    $stmt->bindParam(':districtcode', $decoded[0]->districtcode);
    $stmt->bindParam(':schoolcode', $decoded[0]->schoolcode);
    $stmt->bindParam(':districtname', $decoded[0]->districtname);
    $stmt->bindParam(':districttype', $decoded[0]->districttype);
    $stmt->bindParam(':schoolname', $decoded[0]->schoolname);
    $stmt->bindParam(':schooltype', $decoded[0]->schooltype);
    $stmt->bindParam(':street1', $decoded[0]->street1);
    $stmt->bindParam(':street2', $decoded[0]->street2);
    $stmt->bindParam(':city', $decoded[0]->city);
    $stmt->bindParam(':state', $decoded[0]->state);
    $stmt->bindParam(':zip', $decoded[0]->zip);
    $stmt->bindParam(':county', $decoded[0]->county);
    $stmt->bindParam(':lowestgrade', $decoded[0]->lowestgrade);
    $stmt->bindParam(':highestgrade', $decoded[0]->highestgrade);
    $stmt->bindParam(':educationlevel', $decoded[0]->educationlevel);
    $stmt->bindParam(':hasec', $decoded[0]->hasec);
    $stmt->bindParam(':haspk', $decoded[0]->haspk);
    $stmt->bindParam(':haskn', $decoded[0]->haskn);
    $stmt->bindParam(':haselementarygrade', $decoded[0]->haselementarygrade);
    $stmt->bindParam(':hasmiddlegrade', $decoded[0]->hasmiddlegrade);
    $stmt->bindParam(':hashighgrade', $decoded[0]->hashighgrade);
    $stmt->bindParam(':isungraded', $decoded[0]->isungraded);
    $stmt->bindParam(':geocodedlocation', $decoded[0]->geocodedlocation);

    $stmt->execute();

    $file_db = null;
  }
  catch(PDOException $e) {
    echo $e->getMessage();
  }
  
