CREATE DATABASE IF NOT EXISTS PetHero;

USE PetHero;

CREATE TABLE IF NOT EXISTS size(
    idSize integer not null auto_increment,
    name varchar(50) not null,
    primary key (idSize)
);

CREATE TABLE IF NOT EXISTS guardian(
    idGuardian integer not null auto_increment,
    name varchar(50) not null,
    address varchar(50) not null,
    email varchar(50) not null unique,
    number varchar(50) not null,
    userName varchar(50) not null unique,
    password varchar(50) not null,
    typeUser char(1) not null,
    availabilityStart date,
    availabilityEnd date,
    primary key (idGuardian)
);

CREATE TABLE IF NOT EXISTS owner(
    idOwner integer not null auto_increment,
    name varchar(50) not null,
    address varchar(50) not null,
    email varchar(50) not null unique,
    number varchar(50) not null,
    userName varchar(50) not null unique,
    password varchar(50) not null,
    typeUser char(1) not null,
    primary key (idOwner)
);

CREATE TABLE IF NOT EXISTS pet(
    idPet integer not null auto_increment,
    name varchar(50) not null,
    breed varchar(50) not null,
    idSize integer not null,
    observations varchar(200),
    photo1 blob,
    photo2 blob,
    video blob,
    idOwner integer not null,
    type varchar(50) not null,
    primary key (idPet),
    constraint pet_x_size foreign key (idSize) references size (idSize),
    foreign key (idOwner) references owner (idOwner)
);

/*CREATE TABLE IF NOT EXISTS reserve(




);*/

/*CREATE TABLE IF NOT EXISTS review(




);*/

CREATE TABLE IF NOT EXISTS guardian_x_size(
    idGuardianxSize integer not null auto_increment,
    idGuardian integer not null,
    idSize integer not null,
    constraint PK_guardian_x_size primary key (idGuardianxSize),
    constraint FK_guardianSize_x_guardian foreign key (idGuardian) references guardian (idGuardian),
    constraint FK_guardianSize_x_size foreign key (idSize) references size (idSize)
);

DELIMITER $$

CREATE PROCEDURE Guardian_Add (IN name varchar(50), IN address varchar(50), IN email varchar(50), IN number varchar(50), IN userName varchar(50), IN password varchar(50), IN typeUser char(1), IN availabilityStart date, IN availabilityEnd date)
BEGIN
	INSERT INTO guardian
        (guardian.name, guardian.address, guardian.email, guardian.number, guardian.userName, guardian.password, guardian.typeUser, guardian.availabilityStart, guardian.availabilityEnd)
    VALUES
        (name, address, email, number, userName, password, typeUser, availabilityStart, availabilityEnd);
END$$

DELIMITER;

DELIMITER $$

CREATE PROCEDURE Pet_Add (IN name varchar(50), IN breed varchar(50), IN idSize integer, IN observations varchar(200), IN photo1 blob, IN photo2 blob, IN video blob, IN idOwner integer, IN type varchar  (50))
BEGIN
	INSERT INTO pet
        (pet.name, pet.breed, pet.idSize, pet.observations, pet.photo1, pet.photo2, pet.video, pet.idOwner, pet.type)
    VALUES
        (name, breed, idSize, observations, photo1, photo2, video, idOwner, type);
END$$

DELIMITER;

DELIMITER $$

CREATE PROCEDURE guardian_x_size_Add (IN idGuardian integer, IN idSize integer)
BEGIN
	INSERT INTO guardian_x_size
        (guardian_x_size.idGuardian, guardian_x_size.idSize)
    VALUES
        (idGuardian, idSize);
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE Guardian_GetGuardian (IN email varchar(50))
BEGIN
	SELECT idGuardian, name, address, email, number, userName, password, typeUser, availabilityStart, availabilityEnd
    FROM guardian
    WHERE (guardian.email = email);
END$$

DELIMITER ;

DELIMITER $$
CREATE PROCEDURE Update_AvailabilityStart_Guardian(IN newAvailabilityStart date, IN idGuardianLogged integer)
	UPDATE guardian set availabilityStart = newAvailabilityStart
    WHERE (idGuardian = idGuardianLogged);

CREATE PROCEDURE Update_AvailabilityEnd_Guardian(IN newAvailabilityEnd date, IN idGuardianLogged integer)
	UPDATE guardian set availabilityEnd = newAvailabilityEnd
    WHERE (idGuardian = idGuardianLogged);
    
INSERT INTO size (name) VALUES ('Pequeño'), ('Mediano'), ('Grande');

DELIMITER ;

CREATE PROCEDURE Delete_Dog(in idDogToDelete integer)   
    DELETE FROM pet WHERE idDog = idDogToDelete;
DELIMITER $$

CREATE PROCEDURE Owner_GetOwner (IN email varchar(50))
BEGIN
	SELECT idOwner name, address, email, number, userName, password, typeUser
    FROM owner
    WHERE (owner.email = email);
END$$

DELIMITER ;

DELIMITER $$

CREATE PROCEDURE Owner_Add (IN name varchar(50), IN address varchar(50), IN email varchar(50), IN number varchar(50), IN userName varchar(50), IN password varchar(50), IN typeUser char(1))
BEGIN
	INSERT INTO owner
        (owner.name, owner.address, owner.email, owner.number, owner.userName, owner.password, owner.typeUser)
    VALUES
        (name, address, email, number, userName, password, typeUser);
END$$

DELIMITER;

