/* 0. Reset transactions */
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE persontrans;
TRUNCATE TABLE trans;
SET FOREIGN_KEY_CHECKS=1;

SELECT @virgil_larson := id FROM person where email_canonical = "larso071@umn.edu" LIMIT 1;

/* Insert transaction for received dues, deposit check, and lunch prepay,  up to 3 transactions per person */
/* for each transaction insert a link to and from person in PersonTrans */

insert into Trans ( /*1. 2011-12 Dues Paid */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(DtRcvd1112 != '',STR_TO_DATE(DtRcvd1112, '%c/%e/%Y'),CURDATE()),
'MEMBERSHIP_RENEW',
Dues1112,
'CHECK',
@virgil_larson,
Comments1112,
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Dues1112 is not null and ma.Dues1112 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

insert into Trans ( /*2. 2011-12 Deposit Check */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(Deposit1112 != '',STR_TO_DATE(Deposit1112, '%c/%e/%Y'),CURDATE()),
'OTHER',
Dues1112,
'CHECK',
@virgil_larson,
'',
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Dues1112 is not null and ma.Dues1112 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

/* repeat for 2012-13 */

insert into Trans ( /*3. 2012-13 Dues Paid */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(DtRcvd1213 != '', STR_TO_DATE(DtRcvd1213, '%c/%e/%Y'),CURDATE()),
'MEMBERSHIP_RENEW',
Dues1213,
'CHECK',
@virgil_larson,
Comments1213,
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Dues1213 is not null and ma.Dues1213 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

insert into Trans ( /*4. 2012-13 Deposit Check */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(Deposit1213 != '',STR_TO_DATE(Deposit1213, '%c/%e/%Y'),CURDATE()),
'OTHER',
Dues1213,
'CHECK',
@virgil_larson,
'',
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Dues1213 is not null and ma.Dues1213 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

insert into Trans ( /*5. 2012-13 Lunch Prepay */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(DtRcvd1213 != '',STR_TO_DATE(DtRcvd1213, '%c/%e/%Y'),CURDATE()),
'LUNCHEON_FEE',
Lunchprepay,
'CHECK',
@virgil_larson,
'',
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Lunchprepay is not null and ma.Lunchprepay != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;


insert into Trans ( /*6. 2013-14 Dues Paid */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(DtRcvd1314 != '',STR_TO_DATE(DtRcvd1314, '%c/%e/%Y'),CURDATE()),
'MEMBERSHIP_RENEW',
Dues1314,
'CHECK',
@virgil_larson,
Comments1314,
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Dues1314 is not null and ma.Dues1314 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

insert into Trans ( /*7. 2013-14 Deposit Check */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(Deposit1314 != '',STR_TO_DATE(Deposit1314, '%c/%e/%Y'),CURDATE()),
'OTHER',
Dues1314,
'CHECK',
@virgil_larson,
'',
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Dues1314 is not null and ma.Dues1314 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

insert into Trans ( /*8. 2013-14 Lunch Prepay */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(DtRcvd1314 != '',STR_TO_DATE(DtRcvd1314, '%c/%e/%Y'),CURDATE()),
'LUNCHEON_FEE',
Lunchprepay1314,
'CHECK',
@virgil_larson,
'',
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Lunchprepay1314 is not null and ma.Lunchprepay1314 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

insert into Trans ( /*6. 2014-15 Dues Paid */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(DtRcvd1415 != '',STR_TO_DATE(DtRcvd1415, '%c/%e/%Y'),CURDATE()),
'MEMBERSHIP_RENEW',
Dues1415,
'CHECK',
@virgil_larson,
Comments1415,
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Dues1415 is not null and ma.Dues1415 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

insert into Trans ( /*7. 2014-15 Deposit Check */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(Deposit1415 != '',STR_TO_DATE(Deposit1415, '%c/%e/%Y'),CURDATE()),
'OTHER',
Dues1415,
'CHECK',
@virgil_larson,
'',
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Dues1415 is not null and ma.Dues1415 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

insert into Trans ( /*8. 2014-15 Lunch Prepay */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(DtRcvd1415 != '',STR_TO_DATE(DtRcvd1415, '%c/%e/%Y'),CURDATE()),
'LUNCHEON_FEE',
Lunchprepay1415,
'CHECK',
@virgil_larson,
'',
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Lunchprepay1415 is not null and ma.Lunchprepay1415 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans;

insert into Trans ( /*9. 2015-16 Dues Paid */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(DtRcvd1516 != '',STR_TO_DATE(DtRcvd1516, '%c/%e/%Y'),CURDATE()),
'MEMBERSHIP_RENEW',
Dues1516,
'CHECK',
@virgil_larson,
Comments1516,
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Dues1516 is not null and ma.Dues1516 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

insert into Trans ( /*10. 2015-16 Deposit Check */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(Deposit1516 != '',STR_TO_DATE(Deposit1516, '%c/%e/%Y'),CURDATE()),
'OTHER',
Dues1516,
'CHECK',
@virgil_larson,
'',
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Dues1516 is not null and ma.Dues1516 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans
;

insert into Trans ( /*11. 2015-16 Lunch Prepay */
Trandate,
Trantype,
Amount,
Pmtmethod,
doneby_id,
Notes,
reconciled_date,
status,
PersonID
)
select
IF(DtRcvd1516 != '',STR_TO_DATE(DtRcvd1516, '%c/%e/%Y'),CURDATE()),
'LUNCHEON_FEE',
Lunchprepay1516,
'CHECK',
@virgil_larson,
'',
NOW(),
'PROCESSED',
pe.id
from Masterlist as ma, Person as pe
where (ma.Last = pe.Lastname) and (ma.first = pe.Firstname) and
ma.Lunchprepay1516 is not null and ma.Lunchprepay1516 != ''
;

insert into PersonTrans (
 PersonID,
TransID
)
select
PersonID,
id
from Trans;
