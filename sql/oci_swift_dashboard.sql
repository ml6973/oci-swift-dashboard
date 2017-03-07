DROP DATABASE if EXISTS oci_swift_dashboard;
CREATE DATABASE oci_swift_dashboard;
USE oci_swift_dashboard;

CREATE TABLE Users (
  userId             int(11) NOT NULL AUTO_INCREMENT UNIQUE,
  userName           varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  passwordHash       varchar(255) COLLATE utf8_unicode_ci,
  dateCreated    	 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE UserData (
  userId             int(11) NOT NULL COLLATE utf8_unicode_ci UNIQUE,
  email           	 varchar(255) COLLATE utf8_unicode_ci,
  FOREIGN KEY (userId) REFERENCES Users(userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE Registration (
  userId             int(11) NOT NULL COLLATE utf8_unicode_ci UNIQUE,
  complete			 boolean DEFAULT false,
  FOREIGN KEY (userId) REFERENCES Users(userId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE TenantList (
  tenantId           int(11) NOT NULL AUTO_INCREMENT UNIQUE,
  tenant             varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  description        varchar (255) NOT NULL COLLATE utf8_unicode_ci,
  PRIMARY KEY (tenantId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE Tenants (
  userId             int(11) NOT NULL COLLATE utf8_unicode_ci,
  tenantId			 int(11) NOT NULL COLLATE utf8_unicode_ci,
  PRIMARY KEY (userId, tenantID),
  FOREIGN KEY (userId) REFERENCES Users(userId),
  FOREIGN KEY (tenantId) REFERENCES TenantList(tenantId)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO Users (userId, userName, passwordHash) VALUES 
	   (1, 'Greg', '$2y$10$AlvSVL7GOzho0vBnMEYqROLSrMqQrRttpS.g4qJV3tpcSk5Q5o1om');  
INSERT INTO Users (userId, userName,  passwordHash) VALUES 
	   (2, 'Ryan', '$2y$10$ZqaudocomXwVGEKWErXh5O4c8ib201PVlj2rF5HDCgAnQPChei3p6');
INSERT INTO Users (userId, userName, passwordHash) VALUES 
	   (3, 'Brandon', '$2y$10$AlvSVL7GOzho0vBnMEYqROLSrMqQrRttpS.g4qJV3tpcSk5Q5o1om');  
INSERT INTO Users (userId, userName,  passwordHash) VALUES 
	   (4, 'Farhan', '$2y$10$ZqaudocomXwVGEKWErXh5O4c8ib201PVlj2rF5HDCgAnQPChei3p6');
	  
INSERT INTO UserData (userId, email) VALUES 
	   (1, 'greg@gdail.com');  
INSERT INTO UserData (userId, email) VALUES 
	   (2, 'ryan@gdail.com');
INSERT INTO UserData (userId, email) VALUES 
	   (3, 'brandon@gdail.com');
INSERT INTO UserData (userId, email) VALUES 
	   (4, 'farhan@gdail.com');
	   
INSERT INTO Registration (userId, complete) VALUES 
	   (1, false);
INSERT INTO Registration (userId, complete) VALUES 
	   (2, false);
INSERT INTO Registration (userId, complete) VALUES 
	   (3, false);
INSERT INTO Registration (userId, complete) VALUES 
	   (4, true);
