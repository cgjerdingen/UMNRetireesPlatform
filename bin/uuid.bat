@ECHO OFF
SET BIN_TARGET=%~dp0/../vendor/ramsey/uuid/bin/uuid
php "%BIN_TARGET%" %*
