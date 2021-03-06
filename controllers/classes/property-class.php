<?php
class Property 
{
//class properties
  private $propertyId;
  private $propertyName;
  private $propertyType;
  private $country;
  private $location;
  private $geoLocCoordinates;
  private $address;
  private $owerPhone;
  private $ownerEmail;
  private $numOfAssets;
  private $maxAssetRate;
  private $minAssetRate;
  private $assetRateInterval;
  private $propertyLink;
  private $OwerId;
  private $propertyLogo;
  private $registrationDate;
  private $propertyDescription;

//property modificatinfunctions
  public  function  setPropertyId($propertyId){$this->propertyId=$propertyId;}

  public  function  setPropertyName($propertyName){$this->propertyName=$propertyName;}

  public  function  setPropertyType($propertyType){$this->propertyType=$propertyType;}

  public  function  setCountry($country){$this->country=$country;}

  public  function  setLocation($location){$this->location=$location;}

  public  function  setGeoLocCoordinates($geoLocCoordinates){$this->geoLocCoordinates=$geoLocCoordinates;}

  public  function  setAddress($address){$this->address=$address;}

  public  function  setOwerPhone($owerPhone){$this->owerPhone=$owerPhone;}

  public  function  setOwnerEmail($ownerEmail){$this->ownerEmail=$ownerEmail;}

  public  function  setNumOfAssets($numOfAssets){$this->numOfAssets=$numOfAssets;}

  public  function  setMaxAssetRate($maxAssetRate){$this->maxAssetRate=$maxAssetRate;}

  public  function  setMinAssetRate($minAssetRate){$this->minAssetRate=$minAssetRate;}

  public  function  setAssetRateInterval($assetRateInterval){$this->assetRateInterval=$assetRateInterval;}

  public  function  setPropertyLink($propertyLink){$this->propertyLink=$propertyLink;}

  public  function  setOwerId($OwerId){$this->OwerId=$OwerId;}

  public  function  setPropertyLogo($propertyLogo){$this->propertyLogo=$propertyLogo;}

  public  function  setRegistrationDate($registrationDate){$this->registrationDate=$registrationDate;}

  public  function  setpropertyDescription($propertyDescription){$this->propertyDescription=$propertyDescription;}

 

//value returning functions

  public  function  getPropertyId(){return $this->propertyId;}

  public  function  getPropertyName(){return $this->propertyName;}

  public  function  getPropertyType(){return $this->propertyType;}

  public  function  getCountry(){return $this->country;}

  public  function  getLocation(){return $this->location;}

  public  function  getGeoLocCoordinates(){return $this->geoLocCoordinates;}

  public  function  getAddress(){return $this->address;}

  public  function  getOwerPhone(){return $this->owerPhone;}

  public  function  getOwnerEmail(){return $this->ownerEmail;}

  public  function  getNumOfAssets(){return $this->numOfAssets;}

  public  function  getMaxAssetRate(){return $this->maxAssetRate;}

  public  function  getMinAssetRate(){return $this->minAssetRate;}

  public  function  getAssetRateInterval(){return $this->assetRateInterval;}

  public  function  getPropertyLink(){return $this->propertyLink;}

  public  function  getOwerId(){return $this->OwerId;}

  public  function  getPropertyLogo(){return $this->propertyLogo;}

  public  function  getRegistrationDate(){return $this->registrationDate;}

  public  function  getpropertyDescription(){return $this->propertyDescription;}

public  function listProperty($dbConnect){
  try {
    $q="INSERT INTO properties(
  propertyId,propertyName,propertyType,country,location,geo_loc_coordinates,address,number_of_assests,min_asset_rate,max_asset_rate,  asset_rate_intervals,property_link,property_logo,owerId,
  registration_date,owner_email,owner_phone,property_description)
  VALUES(
  '$this->propertyId','$this->propertyName','$this->propertyType','$this->country','$this->location','$this->geoLocCoordinates','$this->address','$this->numOfAssets','$this->minAssetRate','$this->maxAssetRate','$this->assetRateInterval','$this->propertyLink','$this->propertyLogo','$this->OwerId','$this->registrationDate','$this->ownerEmail','$this->owerPhone','$this->propertyDescription')";
  $query=$dbConnect->prepare($q);
    $query->execute();
    $count=$query->rowCount();
    if($count>0){
      return true;
    }else{
      return FALSE;
    }
  } catch (PDOException $e) {
    return FALSE;
  }
}


public  function findPropertyLink($dbConnect){
    try {
      $q="SELECT property_link FROM properties WHERE property_link='$this->propertyLink'";
          $query=$dbConnect->query($q);
          $query->setFetchMode(PDO::FETCH_ASSOC);
          $result=$query->rowCount();
            if($result>0){
              $rows=$query->fetch();
                return $rows['property_link'];
            }else{
               return 0;
            }
    } catch (PDOException $e) {
         return FALSE;
    }
}


function findPropertyName($dbConnect){
    try {
        $q="SELECT propertyName FROM properties WHERE propertyName='$this->propertyName'";
        $query=$dbConnect->query($q);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result=$query->rowCount();
        if($result>0){
          $rows=$query->fetch();
          return $rows['propertyName'];
        }else{
          return 0;
        }
    } catch (PDOException $e) {
      return FALSE;
    } 
}


function findProperty($dbConnect){
  try {
    $q="SELECT*FROM properties WHERE propertyId='$this->propertyId'";
    $query=$dbConnect->query($q);
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $_num_rows=$query->rowCount();
    if($_num_rows>0){
      $_fetched_array=$query->fetch();
      return $_fetched_array;
    }else{
      return 0;
    }
  } catch (PDOException $e) {
    return FALSE;
  }
}
 }

 ?>
