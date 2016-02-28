/* 0. Reset everything, set correct charset and collation */
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE email;
TRUNCATE TABLE household;
TRUNCATE TABLE person;
TRUNCATE TABLE personrole;
TRUNCATE TABLE persontrans;
TRUNCATE TABLE phone;
TRUNCATE TABLE photo;
TRUNCATE TABLE residence;
TRUNCATE TABLE role;
TRUNCATE TABLE trans;
SET FOREIGN_KEY_CHECKS=1;

ALTER TABLE masterlist CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

/* 1. Set up Household record for main member */
INSERT INTO household (
Lastname,
Firstname,
Postalname
)
SELECT
Last,
first,
labelname
FROM masterlist;

/* 2. Create and link person record for main member */
INSERT INTO person (
Lastname,
Firstname,
Fullname,
Nickname,
Nametagname,
Secondary,
Activenow,
Udeptequiv,
Uempltype,
Membersince,
news_pref,
email_canonical,
HouseholdID
)
SELECT
`Last`,
`first`,
CONCAT(ma.first, ' ', ma.Last),
`first`,
CONCAT(ma.first, ' ', ma.Last),
0,
1,
dept,
(CASE
    WHEN emptype REGEXP '^Civil' THEN
        'civ_srv'
    WHEN emptype REGEXP '^P[[:space:]]?[[.ampersand.]][[:space:]]?A' THEN
        'acad_prof'
    WHEN emptype REGEXP '^Faculty' THEN
        'faculty'
    WHEN emptype REGEXP '[Tt]ech' THEN
        'afscme_tech'
    WHEN emptype REGEXP '[Cc]lerical' THEN
        'afscme_cler'
    WHEN emptype REGEXP '[Tt]eamster' THEN
        'teamster'
ELSE
    NULL
END) as emptype,
STR_TO_DATE(Datejoined, '%c/%e/%Y'),
REPLACE(Newsletter, "usmail", "postal"),
(CASE WHEN `email` = "" THEN NULL ELSE `email` END) as `email`,
ho.id
     FROM masterlist AS ma, household AS ho
WHERE (ma.Last = ho.Lastname) and (ma.first = ho.Firstname) and ma.email != 'dnaumann@umn.edu';



/* 3. Add to Person table the member SSO of a Primary member */
INSERT INTO person (
Lastname,
Firstname,
Fullname,
Nickname,
Nametagname,
Secondary,
Activenow,
Membersince,
HouseholdID
)
SELECT
`spLast`,
`spmember`,
CONCAT(ma.spmember, ' ', ma.spLast),
`spmember`,
CONCAT(ma.spmember, ' ', ma.spLast),
1,
1,
STR_TO_DATE(Datejoined, '%c/%e/%Y'),
ho.id
     FROM masterlist AS ma, household AS ho
WHERE (ma.Last = ho.Lastname) and (ma.first = ho.Firstname) and ma.spLast is not null and ma.spLast != "";

/* 4. Add to Person table the non-member SSO of a Primary member */
INSERT INTO person (
Lastname,
Firstname,
Fullname,
Nickname,
Nametagname,
Secondary,
Activenow,
HouseholdID
)
SELECT
`Last`,
RTRIM(REPLACE(ma.spnonmb, ma.Last, '')),
CONCAT(RTRIM(REPLACE(ma.spnonmb, ma.Last, '')), ' ', ma.Last),
RTRIM(REPLACE(ma.spnonmb, ma.Last, '')),
CONCAT(RTRIM(REPLACE(ma.spnonmb, ma.Last, '')), ' ', ma.spLast),
1,
0,
ho.id
     FROM masterlist AS ma, household AS ho
WHERE (ma.Last = ho.Lastname) and (ma.first = ho.Firstname) and ma.spnonmb is not null and ma.spnonmb != "";

/*5. Add primary residence linked to Household */
INSERT INTO residence (
Prisec,
Address1,
City,
State,
Zip,
Legdistrict,
HouseholdID
)
SELECT
1,
`address`,
`city`,
`state`,
`Zip`,
(CASE WHEN `NewDistrict` = "" THEN NULL ELSE `NewDistrict` END),
ho.id
    FROM masterlist AS ma, household AS ho
    WHERE (ma.Last = ho.Lastname) and (ma.first = ho.Firstname) and ma.address is not null and ma.address != "";

    /*6. Add alternative residence linked to Household */
INSERT INTO residence (
Prisec,
Address1,
City,
State,
Zip,
Forseason,
HouseholdID
)
SELECT
0,
`AltAddress`,
`AltCity`,
`AltState`,
`AltZip`,
(CASE WHEN ma.UseAltAddress = "" THEN NULL ELSE ma.UseAltAddress END),
ho.id
    FROM masterlist AS ma, household AS ho
    WHERE (ma.Last = ho.Lastname) and (ma.first = ho.Firstname)
    AND ma.AltAddress IS NOT NULL and ma.AltAddress != "";


/* 7. Link Primary Phone number to Residence */
INSERT INTO phone (
Phnumber,
Phtype,
ResID
)
SELECT
SUBSTRING_INDEX(`telephone`, ' ', 1),
'shared',
re.id
     FROM masterlist AS ma, household AS ho, residence AS re
WHERE (ma.Last = ho.Lastname) and (ma.first = ho.Firstname)
AND   (re.HouseholdID = ho.id) AND re.Prisec = 1 AND ma.telephone is not null AND ma.telephone != "";

/* 8. Link second Phone number as U of M office number to member in Person */
INSERT INTO phone (
Phnumber,
Phtype,
PersonID
)
SELECT
SUBSTRING_INDEX(`Telephone2`, ' ', 1),
'work',
pe.id
     FROM masterlist AS ma, person AS pe
WHERE (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and ma.Telephone2 LIKE '612-62%';

/* 9. Link second Phone number as cellphone number to member in Person */
INSERT INTO phone (
Phnumber,
Phtype,
PersonID
)
SELECT
SUBSTRING_INDEX(`Telephone2`, ' ', 1),
'mobile',
pe.id
     FROM masterlist AS ma, person AS pe
    WHERE (ma.Last = pe.Lastname) and (ma.first = pe.Firstname)
    AND ma.Telephone2 NOT LIKE '612-62%' AND ma.Telephone2 IS NOT NULL and ma.telephone2 != "";

/* 10. Link alternative residence home phone number to alternative Residence */
INSERT INTO phone (
Phnumber,
Phtype,
ResID
)
SELECT
SUBSTRING_INDEX(`Altphone`, ' ', 1),
'shared',
re.id
     FROM masterlist AS ma, residence AS re
    WHERE (ma.AltAddress = re.Address1) and (ma.AltCity = re.City)
    AND ma.AltPhone IS NOT NULL and ma.AltPhone != "";

/* 11. Link email to Household */
INSERT INTO email (
`Type`,
Email,
HouseholdID
)
SELECT
'shared',
`email`,
ho.id
     FROM masterlist AS ma, household AS ho
    WHERE (ma.Last = ho.Lastname) and (ma.first = ho.Firstname)
    AND ma.email IS NOT NULL and ma.email != "" and ma.email != 'dnaumann@umn.edu';

/* 12. Link secondary email to Person */
INSERT INTO email (
Preferred,
`Type`,
Email,
PersonID
)
SELECT
1,
'personal',
`Secondemail`,
pe.id
     FROM masterlist AS ma, person AS pe
    WHERE (ma.Last = pe.Lastname) and (ma.first = pe.Firstname)
    AND ma.Secondemail IS NOT NULL and ma.Secondemail != "";


/* 13. Provide empty roles for newly created people */
UPDATE person SET roles = 'a:1:{i:0;s:9:"ROLE_USER";}' WHERE roles = "";
