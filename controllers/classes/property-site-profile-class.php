<?php
class PropertySiteProfile{
   	private $siteProfileId;
    private $propertyId;
    private $propertyHeading;
    private $site_profileSubheading;
    private $propertyCoverPhoto;
    private $propertyAddress;
    private $propertyEmail;
    private $propertyPhone;
    private $propertyMapInfo;
    //property data modifying  functions
    public function setSiteProfileId($siteProfileId){
      $this->siteProfileId=$siteProfileId;
    }
    public function  setPropertyId($propertyId){
      $this->propertyId=$propertyId;
    }
    public function  setPropertyHeading($propertyHeading){
      $this->propertyHeading=$propertyHeading;
    }
    public function  setSiteProfileSubheading($site_profileSubheading){
      $this->site_profileSubheading=$site_profileSubheading;
    }
    public function  setPropertyCoverPhoto($propertyCoverPhoto){
      $this->propertyCoverPhoto=$propertyCoverPhoto;
    }
    public function  setPropertyAddress($propertyAddress){
      $this->propertyAddress=$propertyAddress;
    }
    public  function setPropertyEmail($propertyEmail){
      $this->propertyEmail=$propertyEmail;
    }
    public function  setPropertyPhone($propertyPhone){
      $this->propertyPhone=$propertyPhone;
    }
    public function  setPropertyMapInfo($propertyMapInfo){
        $this->propertyMapInfo=$propertyMapInfo;
    }
    //value returning function
    public function  getSiteProfileId(){
      return $this->siteProfileId;
    }
    public  function getPropertyId(){
      return $this->propertyId;
    }
    public function  getPropertyHeading(){
      return $this->propertyHeading;
    }

    public function  getSiteProfileSubheading(){
      return $site_profileSubheading;
    }

    public  function getPropertyCoverPhoto(){
      return $propertyCoverPhoto;
    }

    public  function getPropertyAddress(){
      return $thsi->propertyAddress;
    }
    public  function getPropertyEmail(){
      return $propertyEmail;
    }
    public function  getPropertyPhone(){
      return $propertyPhone;
    }
    public function  getpropertyMapInfo(){
      return $propertyMapInfo;
    }
    public function createSiteProfile($connect){
      try {
        $sql="INSERT INTO site_profile(
        siteProfileId,
        propertyId,
        propertyHeading,
        site_profileSubheading,
        propertyCoverPhoto,
        propertyAddress,
        propertyEmail,
        propertyPhone,
        propertyMapInfo)
        VALUES(
          '$this->siteProfileId',
          '$this->propertyId',
          '$this->propertyHeading',
          '$this->site_profileSubheading',
          '$this->propertyCoverPhoto',
          '$this->propertyAddress',
          '$this->propertyEmail',
          '$this->propertyPhone',
          '$this->propertyMapInfo')";
      $query=$connect->prepare($sql);
        $query->execute();
        $count=$query->rowCount();
        if ($count>0) {
          return true;
        } else {
          return FALSE;
        } 
      } catch (PDOException $e) {
        return FALSE;
      }
    }

    public function updatePropertySiteInfo($conn){
      try {
              $sql="UPDATE site_profile SET
        propertyHeading='$this->propertyHeading',
        site_profileSubheading='$this->site_profileSubheading',
        propertyCoverPhoto='$this->propertyCoverPhoto',
        propertyAddress='$this->propertyAddress',
        propertyEmail='$this->propertyEmail',
        propertyPhone='$this->propertyPhone',
        propertyMapInfo='$this->propertyMapInfo' WHERE  propertyId='$this->siteProfileId'";

        $query=$connect->prepare($sql);
        $query->execute();
        $count=$query->rowCount();
        if ($count>0) {
          return true;
        } else {
          return FALSE;
        }
      } catch (PDOException $e) {
        return FALSE;
      }

    }
}
?>
