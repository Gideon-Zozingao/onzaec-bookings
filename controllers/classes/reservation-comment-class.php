<?php

class reservationComment
{
private $commentId;
private $reservationId;
private $userId;
private $commentText;
private $commentDate;
private $commentTime;
  function __construct($commentId)
  {
    $this->commentId=$commentId;
  }

  public function setReservationId($reservationId){
    $this->reservationId=$reservationId;
  }
  public function setUserId($userId){
    $this->userId=$userId;
  }
  public function setCommentText($commentText){
    $this->commentText=$commentText;
  }

  public function setCommentDate($commentDate){
    $this->commentDate=$commentDate;
  }

  public function setCommentTime($commentTime){
    $this->commentTime=$commentTime;
  }
  public function getCommentId(){
    return $this->commentId;
  }
  public function getReservationId(){
    return $this->reservationId;
  }
  public function getUserId(){
    return $this->userId;
  }
  public function getCommentText(){
    return $this->commentText;
  }
  public function getCommentDate(){
    return $this->commentDate;
  }
  public function getCommentTime(){
    return $this->commentTime;
  }

  public function resgisterComment($conn){
    try {
      $sql="INSERT INTO reservation_comments(commentId,   reservationId,userId,commentText,commentDate,commentTime) VALUES('$this->commentId','$this->reservationId','$this->userId','$this->commentText','$this->commentDate','$this->commentTime')";
            $query=$conn->prepare($sql);
            $query->execute();
            $count=$query->rowCount();
            if($count>0) {
                return true;
          }else {
                return FALSE;
          }
    } catch (PDOException $e) {
      return  FALSE;
    }
    
  }
  
  public function deleteComment($conn){
    try {
        $sql="DELETE FROM reservation_comments WHERE commentId='$this->commentId'";
          $query=$conn->prepare($sql);
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
