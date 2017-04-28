DROP DATABASE if EXISTS oci_swift_dashboard;
CREATE DATABASE oci_swift_dashboard;
USE oci_swift_dashboard;

CREATE TABLE Users (
  userId             int(11) NOT NULL AUTO_INCREMENT UNIQUE,
  userName           varchar (255) UNIQUE NOT NULL COLLATE utf8_unicode_ci,
  passwordHash           varchar(255) COLLATE utf8_unicode_ci,
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
  name               varchar (255) NOT NULL COLLATE utf8_unicode_ci,
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