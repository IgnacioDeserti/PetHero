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
    price float,
    status int default 1,
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
    status int default 1,
    primary key (idOwner)
);

CREATE TABLE IF NOT EXISTS pet(
    idPet integer not null auto_increment,
    name varchar(50) not null,
    breed varchar(50) not null,
    idSize integer not null,
    observations varchar(200),
    photo1 blob not null,
    photo2 blob not null,
    video blob,
    idOwner integer not null,
    type varchar(50) not null,
    status int default 1,
    primary key (idPet),
    constraint pet_x_size foreign key (idSize) references size (idSize),
    foreign key (idOwner) references owner (idOwner)
);

CREATE TABLE IF NOT EXISTS reservation(
    idReservation integer not null auto_increment,
    idOwner integer not null,
    idGuardian integer not null,
    idPet integer not null,
    breed varchar (50) not null,
    animalType varchar(1) not null,
    reservationDateStart date not null,
    reservationDateEnd date not null,
    reservationStatus varchar(50) null default 'Esperando Confirmacion',
    size varchar(50) not null,
    price float not null,
    primary key (idReservation),
    constraint fk_idOwner foreign key (idOwner) references owner (idOwner),
    constraint fk_idGuardian foreign key (idGuardian) references guardian (idGuardian)
);


CREATE TABLE IF NOT EXISTS review(
    idReview integer not null auto_increment,
    rating float not null,
    observations varchar(200) not null,
    idOwner integer not null,
    idGuardian integer not null,
    idReservation integer not null,
    primary key (idReview),
    constraint idOwner foreign key (idOwner) references owner (idOwner),
    constraint idGuardian foreign key (idGuardian) references guardian (idGuardian),
    constraint idReservation foreign key (idReservation) references reservation (idReservation)
);

CREATE TABLE IF NOT EXISTS guardian_x_size(
    idGuardianxSize integer not null auto_increment,
    idGuardian integer not null,
    idSize integer not null,
    constraint PK_guardian_x_size primary key (idGuardianxSize),
    constraint FK_guardianSize_x_guardian foreign key (idGuardian) references guardian (idGuardian),
    constraint FK_guardianSize_x_size foreign key (idSize) references size (idSize)
);

CREATE TABLE IF NOT EXISTS paymentCoupon(
    idPayment integer not null auto_increment,
    ownerName varchar(50) not null,
    guardianName varchar(50) not null,
    petName varchar(50) not null,
    price float not null,
    dateP date not null,
    titular varchar(50) not null,
    reservationNumber integer not null,
    constraint PK_idPayment primary key (idPayment),
    constraint FK_reservationNumber foreign key (reservationNumber) references reservationNumber (idReservation)
);

DELIMITER //

CREATE PROCEDURE Guardian_Add (IN name varchar(50), IN address varchar(50), IN email varchar(50), IN number varchar(50), IN userName varchar(50), IN password varchar(50), IN typeUser char(1), IN availabilityStart date, IN availabilityEnd date, IN price float)
BEGIN
	INSERT INTO guardian
        (guardian.name, guardian.address, guardian.email, guardian.number, guardian.userName, guardian.password, guardian.typeUser, guardian.availabilityStart, guardian.availabilityEnd, guardian.price)
    VALUES
        (name, address, email, number, userName, password, typeUser, availabilityStart, availabilityEnd,price);
END//


DELIMITER //

CREATE PROCEDURE Pet_Add (IN name varchar(50), IN breed varchar(50), IN idSize integer, IN observations varchar(200), IN photo1 blob, IN photo2 blob, IN video blob, IN idOwner integer, IN type varchar (50))
BEGIN
	INSERT INTO pet
        (pet.name, pet.breed, pet.idSize, pet.observations, pet.photo1, pet.photo2, pet.video, pet.idOwner, pet.type)
    VALUES
        (name, breed, idSize, observations, photo1, photo2, video, idOwner, type);
END//

DELIMITER //

CREATE PROCEDURE guardian_x_size_Add (IN idGuardian integer, IN idSize integer)
BEGIN
	INSERT INTO guardian_x_size
        (guardian_x_size.idGuardian, guardian_x_size.idSize)
    VALUES
        (idGuardian, idSize);
END//

DELIMITER //

CREATE PROCEDURE Guardian_GetGuardian (IN email varchar(50))
BEGIN
	SELECT idGuardian, name, address, email, number, userName, password, typeUser, availabilityStart, availabilityEnd, price
    FROM guardian
    WHERE (guardian.email = email);
END//

DELIMITER //
CREATE PROCEDURE Guardian_GetGuardianById (IN idG integer)
BEGIN
	SELECT idGuardian, name, address, email, number, userName, password, typeUser, availabilityStart, availabilityEnd, price
    FROM guardian
    WHERE (guardian.idGuardian = idG);
END//

DELIMITER //
CREATE PROCEDURE Update_AvailabilityStart_Guardian(IN newAvailabilityStart date, IN idGuardianLogged integer)
BEGIN
	UPDATE guardian set availabilityStart = newAvailabilityStart
    WHERE (idGuardian = idGuardianLogged);
END//

DELIMITER //
CREATE PROCEDURE Update_AvailabilityEnd_Guardian(IN newAvailabilityEnd date, IN idGuardianLogged integer)
BEGIN
	UPDATE guardian set availabilityEnd = newAvailabilityEnd
    WHERE (idGuardian = idGuardianLogged);
END//
    
INSERT INTO size (name) VALUES ('Pequeño'), ('Mediano'), ('Grande');

DELIMITER //
CREATE PROCEDURE Delete_Dog(in idDogToDelete integer)   
BEGIN
    DELETE FROM pet WHERE idDog = idDogToDelete;
END//


DELIMITER //
CREATE PROCEDURE Owner_GetOwner (IN email varchar(50))
BEGIN
	SELECT idOwner, name, address, email, number, userName, password, typeUser
    FROM owner
    WHERE (owner.email = email);
END//


DELIMITER //

CREATE PROCEDURE Owner_Add (IN name varchar(50), IN address varchar(50), IN email varchar(50), IN number varchar(50), IN userName varchar(50), IN password varchar(50), IN typeUser char(1))
BEGIN
	INSERT INTO owner
        (owner.name, owner.address, owner.email, owner.number, owner.userName, owner.password, owner.typeUser)
    VALUES
        (name, address, email, number, userName, password, typeUser);
END//


DELIMITER //

CREATE PROCEDURE Review_Add (IN rating float, IN observations varchar(200), IN idOwner integer, IN idGuardian integer, IN idReservation integer)
BEGIN
    INSERT INTO review
        (review.idOwner, review.idGuardian, review.idOwner, review.idGuardian)
    VALUES
        (rating, observations, idOwner, idGuardian, idReservation);
END//

DELIMITER //

CREATE PROCEDURE Review_Delete (in idReview integer)
BEGIN
    DELETE FROM review WHERE review.idReview = idReview;
END//


DELIMITER //

CREATE PROCEDURE Reservation_Add (IN idOwner integer, IN idGuardian integer, IN idPet integer, IN breed varchar(50), IN animalType varchar(1), IN reservationDateStart date, IN reservationDateEnd date, IN size varchar(30), IN price float)
BEGIN
    INSERT INTO reservation
        (reservation.idOwner, reservation.idGuardian, reservation.idPet, reservation.breed, reservation.animalType, reservation.reservationDateStart, reservation.reservationDateEnd, reservation.size, reservation.price)
    VALUES
        (idOwner, idGuardian, idPet, breed, animalType, reservationDateStart, reservationDateEnd, size, price);
END//



DELIMITER //
CREATE PROCEDURE Reservation_Delete (in idReservation integer)
BEGIN
    DELETE FROM reservation WHERE reservation.idReservation = idReservation;
END//

DELIMITER //
CREATE PROCEDURE Guardian_x_SizeGetAll ()
BEGIN
	SELECT idGuardianxSize, idGuardian, idSize
    FROM guardian_x_size;
END//

DELIMITER //

CREATE PROCEDURE Size_GetName (IN idSizeS integer)
BEGIN
	SELECT name
    FROM Size
    WHERE Size.idSize = idSizeS;
END//

DELIMITER //
CREATE PROCEDURE Size_GetAll ()
BEGIN
	SELECT idSize, name
    FROM Size;
END//

insert into size(name) values("Pequeño"), ("Mediano"), ("Grande");

DELIMITER //
CREATE PROCEDURE GetOwnerByUserName (IN userName varchar(50))
BEGIN
	SELECT idOwner, name, address, email, number, userName, password, typeUser
    FROM owner
    WHERE (owner.userName = userName);
END//

DELIMITER //
CREATE PROCEDURE GetGuardianByUserName (IN userName varchar(50))
BEGIN
	SELECT idGuardian, name, address, email, number, userName, password, typeUser, availabilityStart, availabilityEnd, price
    FROM guardian
    WHERE (guardian.userName = userName);
END//

DELIMITER //
CREATE PROCEDURE Owner_GetOwnerById (IN idS int)
BEGIN
	SELECT name
    FROM owner
    WHERE (owner.id = idS);
END//

DELIMITER //
CREATE PROCEDURE Owner_GetPetByIdOwner (IN idS int)
BEGIN
	SELECT *
    FROM Pet 
    WHERE Pet.ownerId = idS;
END//

DELIMITER //
CREATE PROCEDURE Reservation_GetReservationsByIdGuardian (in idGuardianS integer)
BEGIN
	SELECT *
    FROM reservation  
    WHERE reservation.idGuardian = idGuardianS and reservation.reservationStatus != 'Cancelado' ;
END//
reservationDateStart
DELIMITER //
CREATE PROCEDURE Reservation_GetReservationsByIdOwner (in idOwnerS integer)
BEGIN
	SELECT *
    FROM reservation  
    WHERE reservation.idOwner = idOwnerS and reservation.reservationStatus != 'Cancelado' ;
END//

DELIMITER //
CREATE PROCEDURE Reservation_GetReservationById (in idRes integer)
BEGIN
	SELECT *
    FROM reservation  
    WHERE reservation.idReservation = idRes and reservation.reservationStatus != 'Cancelado' ;
END//

DELIMITER //
CREATE PROCEDURE Reservation_GetDates (in idGuardianS int)
BEGIN
	SELECT Reservation.reservationDateStart, Reservation.reservationDateEnd, Reservation.breed, Reservation.animalType, Reservation.size
    FROM Reservation  
    WHERE Reservation.idGuardian = idGuardianS and reservation.reservationStatus != 'Cancelado' 
    ORDER BY Reservation.reservationDateStart ASC;
END//

DELIMITER //
CREATE PROCEDURE Review_GetReviewsByGuardian (in idGuardianS int)
BEGIN
	SELECT *
    FROM Review 
    WHERE Review.idGuardian = idGuardianS;
END//

DELIMITER //
CREATE PROCEDURE guardian_x_size_GetSizeByIdGuardian (in idGuardianS int)
BEGIN
	SELECT idSize
    FROM guardian_x_size 
    WHERE guardian_x_size.idGuardian = idGuardianS;
END//

DELIMITER //
CREATE PROCEDURE Guardian_GetAvailabilityStart (in idGuardianS int)
BEGIN
	SELECT availabilityStart
    FROM guardian
    WHERE guardian.idGuardian = idGuardianS;
END//

DELIMITER //
CREATE PROCEDURE Guardian_GetAvailabilityEnd (in idGuardianS int)
BEGIN
	SELECT availabilityEnd
    FROM guardian
    WHERE guardian.idGuardian = idGuardianS;
END//

DELIMITER //
CREATE PROCEDURE Pet_GetPetById (in idPetS int)
BEGIN
	SELECT *
    FROM pet
    WHERE pet.idPet = idPetS;
END//

DELIMITER //
CREATE PROCEDURE reservation_changeStatus (in idReservationS int, in statusS varchar(30))
BEGIN
	UPDATE reservation SET reservation.reservationStatus = statusS WHERE reservation.idReservation = idReservationS;
END//

DELIMITER //
CREATE PROCEDURE Reservation_getReservationByStatusAndIdOwner (IN stat varchar(50), IN idOwnerR integer)
BEGIN
    SELECT *
    FROM Reservation
    WHERE Reservation.idOwner = idOwnerR AND Reservation.reservationStatus = stat and reservation.reservationStatus != 'Cancelado' ;;
END//


DELIMITER //
CREATE PROCEDURE Reservation_getReservationByStatusAndIdGuardian (IN stat varchar(50), IN idGuardianR integer)
BEGIN
    SELECT *
    FROM Reservation
    WHERE Reservation.idGuardian = idGuardianR AND Reservation.reservationStatus = stat;
END//


DELIMITER //
CREATE PROCEDURE Pet_GetNameByIdPet (in idPetS int)
BEGIN
	SELECT pet.name
    FROM pet
    WHERE pet.idPet = idPetS;
END//

DELIMITER //
CREATE PROCEDURE paymentCoupon_Add (in idPaymentS int, in ownerNameS varchar(50), in guardianNameS varchar(50, in petNameS),in priceS float, in dateS date, in titularS varchar(50), in reservationNumberS integer)
BEGIN
	INSERT INTO paymentCoupon (idPayment, ownerName, guardianName, petName, price,  dateP, titular, reservationNumber)
    VALUES (idPaymentS, ownerNameS, guardianNameS, petNameS, priceS, dateS, titularS, reservationNumberS);
END//

DELIMITER //
CREATE PROCEDURE paymentCoupon_getPaymentById (in idRes int)
BEGIN
	SELECT *
    FROM paymentCoupon
    WHERE paymentCoupon.reservationNumber = idRes;
END//