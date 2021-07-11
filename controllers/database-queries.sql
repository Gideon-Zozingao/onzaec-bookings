CREATE TABLE `onzaec-bookings`.`user` (
  `userId` VARCHAR(50) NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  `dateOfBirth` DATE NOT NULL,
  `gender` VARCHAR(45) NOT NULL,
  `country` VARCHAR(45) NOT NULL,
  `state` VARCHAR(45) NOT NULL,
  `address` VARCHAR(45) NULL,
  `phone` BIGINT(14) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `userType` VARCHAR(45) NOT NULL,
  `avata` VARCHAR(55) NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `registrationDate` DATE NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE INDEX `phone_UNIQUE` (`phone` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
  ENGINE = InnoDB;

  CREATE TABLE `onzaec-bookings`.`properties` (
    `propertyId` VARCHAR(50) NOT NULL,
    `propertyName` VARCHAR(45) NOT NULL,
    `propertyType` VARCHAR(45) NOT NULL,
    `country` VARCHAR(45) NOT NULL,
    `location` VARCHAR(45) NOT NULL,
    `geo_loc_coordinates` FLOAT NULL,
    `address` VARCHAR(300) NOT NULL,
    `number_of_assests` INT NULL,
    `min_asset_rate` INT UNSIGNED NOT NULL,
    `max_asset_rate` INT UNSIGNED NOT NULL,
    `asset_rate_intervals` VARCHAR(100) NOT NULL,
    `property_link` VARCHAR(500) NOT NULL,
    `property_logo` VARCHAR(50) NULL,
    `owerId` VARCHAR(50) NOT NULL,
    `registration_date` DATE NOT NULL,
    `owner_email` VARCHAR(200) NOT NULL,
    `owner_phone` BIGINT(14) NOT NULL,
    PRIMARY KEY (`propertyId`),
    INDEX `properties_fk_idx` (`owerId` ASC),
    UNIQUE INDEX `property_link_UNIQUE` (`property_link` ASC),
    UNIQUE INDEX `propertyId_UNIQUE` (`propertyId` ASC),
    CONSTRAINT `properties_fk`
      FOREIGN KEY (`owerId`)
      REFERENCES `onzaec-bookings`.`user` (`userId`)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION)
      ENGINE = InnoDB;

ALTER TABLE `properties`
ADD `property_description`
VARCHAR(600) NOT NULL AFTER `owner_phone`;


CREATE TABLE `onzaec-bookings`.`site_profile` (
  `siteProfileId` VARCHAR(50) NOT NULL,
  `propertyId` VARCHAR(50) NOT NULL,
  `propertyHeading` VARCHAR(200) NULL,
  `site_profileSubheading` VARCHAR(500) NULL,
  `propertyCoverPhoto` VARCHAR(50) NULL,
  `propertyAddress` VARCHAR(100) NULL,
  `propertyEmail` VARCHAR(45) NOT NULL,
  `propertyPhone` BIGINT(12) UNSIGNED NOT NULL,
  `propertyMapInfo` VARCHAR(100) NULL,
  PRIMARY KEY (`siteProfileId`),
  UNIQUE INDEX `propertyEmail_UNIQUE` (`propertyEmail` ASC),
  UNIQUE INDEX `propertyPhone_UNIQUE` (`propertyPhone` ASC),
  INDEX `property_profile_fk_idx` (`propertyId` ASC),
  CONSTRAINT `property__fk`
    FOREIGN KEY (`propertyId`)
    REFERENCES `onzaec-bookings`.`properties` (`propertyId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

ALTER TABLE `site_profile` CHANGE `propertyMapInfo` `propertyMapInfo` VARCHAR(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;



CREATE TABLE `onzaec-bookings`.`user_accounts` (
  `accId` VARCHAR(50) NOT NULL,
  `accountName` VARCHAR(500) NOT NULL,
  `accountType` VARCHAR(45) NOT NULL,
  `userType` VARCHAR(45) NOT NULL,
  `accoutOwnerId` VARCHAR(50) NOT NULL,
  `registrationDate` DATE NOT NULL,
  PRIMARY KEY (`accId`),
  INDEX `account_fk_idx` (`accoutOwnerId` ASC),
  CONSTRAINT `account_fk`
    FOREIGN KEY (`accoutOwnerId`)
    REFERENCES `onzaec-bookings`.`user` (`userId`)
    ON DELETE  CASCADE
    ON UPDATE  CASCADE)
    ENGINE = InnoDB;
ALTER TABLE `user_accounts` ADD `accountStatus` VARCHAR(100) NOT NULL AFTER `registrationDate`;

    CREATE TABLE `onzaec-bookings`.`rooms` (
      `roomId` VARCHAR(50) NOT NULL,
      `roomName` VARCHAR(50) NOT NULL,
      `roomCategory` VARCHAR(50) NOT NULL,
      `FloorNumber` INT NOT NULL,
      `roomCapacity` INT NOT NULL,
      `numberOfBed` INT NOT NULL,
      `bedSize` FLOAT NOT NULL,
      `facilitiesl` VARCHAR(500) NULL,
      `price` FLOAT NOT NULL,
      `tax` FLOAT NOT NULL,
      `availabilityStatus` VARCHAR(45) NOT NULL,
      `avaialibiltyDate` DATE NOT NULL,
      `roomDescription` VARCHAR(45) NULL,
      `propertyId` VARCHAR(50) NOT NULL,
      PRIMARY KEY (`roomId`),
      UNIQUE INDEX `roomId_UNIQUE` (`roomId` ASC),
      INDEX `rooms_fk_idx` (`propertyId` ASC),
      CONSTRAINT `rooms_fk`
        FOREIGN KEY (`propertyId`)
        REFERENCES `onzaec-bookings`.`properties` (`propertyId`)
        ON DELETE CASCADE
        ON UPDATE CASCADE)
    ENGINE = InnoDB;
ALTER TABLE `rooms` ADD `roomCoverPhoto` VARCHAR(500) NOT NULL AFTER `roomDescription`;
ALTER TABLE `rooms` CHANGE `roomCoverPhoto` `roomCoverPhoto` VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL;
ALTER TABLE `rooms` ADD `publoicationStatus` VARCHAR(25) NULL AFTER `roomCoverPhoto`;

ALTER TABLE `user` CHANGE `dateOfBirth` `dateOfBirth` DATE NULL, CHANGE `state` `state` VARCHAR(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL, CHANGE `phone` `phone` BIGINT NULL;
CREATE TABLE `onzaec-bookings`.`employee` (
  `empId` VARCHAR(50) NOT NULL,
  `empName` VARCHAR(45) NOT NULL,
  `empSurName` VARCHAR(45) NOT NULL,
  `empEmail` VARCHAR(200) NOT NULL,
  `empType` VARCHAR(45) NOT NULL,
  `empUserId` VARCHAR(50) NOT NULL,
  `siteManagementPrevillige` VARCHAR(25) NULL,
  `assetManagementPrevillige` VARCHAR(24) NULL,
  `customerService` VARCHAR(25) NULL,
  `newsLetterPrevillige` VARCHAR(25) NULL,
  `propertyNewsPrevillige` VARCHAR(25) NULL,
  `promotionsAndAdsPrevillieg` VARCHAR(25) NULL,
  PRIMARY KEY (`empId`),
  UNIQUE INDEX `empId_UNIQUE` (`empId` ASC),
  INDEX `employee_fk_idx` (`empUserId` ASC),
  CONSTRAINT `employee_fk`
    FOREIGN KEY (`empUserId`)
    REFERENCES `onzaec-bookings`.`user` (`userId`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;
ALTER TABLE `employee` ADD `eventManagementPrevillieg` VARCHAR(25) NOT NULL AFTER `promotionsAndAdsPrevillieg`,
ADD `empRegDate` DATE NOT NULL AFTER `eventManagementPrevillieg`;


CREATE TABLE `onzaec-bookings`.`propertyphotos` (
  `photoId` BIGINT(50) NOT NULL,
  `photoName` VARCHAR(50) NOT NULL,
  `propertyId` VARCHAR(50) NOT NULL,
  `photoAltext` VARCHAR(200) NULL,
  `creattionDate` DATE NOT NULL,
  PRIMARY KEY (`photoId`),
  INDEX `propertyphoto_fk_idx` (`propertyId` ASC),
  CONSTRAINT `propertyphoto_fk`
    FOREIGN KEY (`propertyId`)
    REFERENCES `onzaec-bookings`.`properties` (`propertyId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

ALTER TABLE `propertyphotos` CHANGE `creattionDate` `creattionDate` DATETIME NOT NULL;

ALTER TABLE `rooms` CHANGE `roomDescription` `roomDescription` VARCHAR(6000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;

CREATE TABLE `onzaec-bookings`.`customers` (
  `customerId` VARCHAR(50) NOT NULL,
  `customerName` VARCHAR(45) NOT NULL,
  `customerSurname` VARCHAR(45) NOT NULL,
  `customerPhone` VARCHAR(45) NOT NULL,
  `customerEmail` VARCHAR(200) NOT NULL,
  `customerCountry` VARCHAR(200) NOT NULL,
  `customerFirstTransDate` DATE NULL,
  PRIMARY KEY (`customerId`))
ENGINE = InnoDB;


CREATE TABLE `onzaec-bookings`.`bookings` (
  `bookingId` VARCHAR(50) NOT NULL,
  `roomId` VARCHAR(50) NOT NULL,
  `propertyId` VARCHAR(50) NOT NULL,
  `checkInDate` DATE NOT NULL,
  `checkOutDate` DATE NOT NULL,
  `customerId` VARCHAR(50) NULL,
  `reservationCode` INT(6) UNSIGNED NOT NULL,
  `reservationStatus` VARCHAR(45) NOT NULL,
  `reservationDate` DATE NOT NULL,
  `numberOfChildren` INT(2) NOT NULL,
  `numberOfAdult` INT(2) NOT NULL,
  `reservationNoticeSeen` VARCHAR(10) NOT NULL,
  `customerReservationMessage` VARCHAR(5000) NULL,
  `reservationComment` VARCHAR(5000) NULL,
  `reservationBill` FLOAT NOT NULL,
  PRIMARY KEY (`bookingId`),
  INDEX `roomId_fk_idx` (`roomId` ASC),
  INDEX `propertyId_fk_idx` (`propertyId` ASC),
  INDEX `customerId_fk_idx` (`customerId` ASC),
  CONSTRAINT `roomId_fk`
    FOREIGN KEY (`roomId`)
    REFERENCES `onzaec-bookings`.`rooms` (`roomId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `propertyId_fk`
    FOREIGN KEY (`propertyId`)
    REFERENCES `onzaec-bookings`.`properties` (`propertyId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `customerId_fk`
    FOREIGN KEY (`customerId`)
    REFERENCES `onzaec-bookings`.`customers` (`customerId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `onzaec-bookings`.`reservation_comments` (
  `commentId` VARCHAR(50) NOT NULL,
  `reservationId` VARCHAR(50) NULL,
  `userId` VARCHAR(50) NULL,
  `commentText` VARCHAR(600) NULL,
  `commentDate` DATE NULL,
  `commentTime` VARCHAR(45) NULL,
  PRIMARY KEY (`commentId`),
  UNIQUE INDEX `commentId_UNIQUE` (`commentId` ASC),
  INDEX `reservationId_fk_idx` (`reservationId` ASC),
  INDEX `userId_fk_idx` (`userId` ASC),
  CONSTRAINT `reservationId_fk`
    FOREIGN KEY (`reservationId`)
    REFERENCES `onzaec-bookings`.`bookings` (`bookingId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `userId_fk`
    FOREIGN KEY (`userId`)
    REFERENCES `onzaec-bookings`.`user` (`userId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE `onzaec-bookings`.`roomphotos` (
  `photoId` VARCHAR(50) NOT NULL,
  `photoName` VARCHAR(50) NOT NULL,
  `roomId` VARCHAR(50) NOT NULL,
  `photoAltText` VARCHAR(200) NULL,
  `createdDate` DATE NULL,
  PRIMARY KEY (`photoId`),
  UNIQUE INDEX `photoId_UNIQUE` (`photoId` ASC),
  INDEX `rooId_fk_idx` (`roomId` ASC),
  CONSTRAINT `rooId_fk`
    FOREIGN KEY (`roomId`)
    REFERENCES `onzaec-bookings`.`rooms` (`roomId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;
