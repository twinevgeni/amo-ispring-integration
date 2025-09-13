<?php

define('PHP_INFO_ENABLED', true); //default false

define('LOG_VARDUMP_ENABLED', false); //default false
define('LOG_STDOUT_ENABLED', true); //default false

define('LOG_FILE_ENABLED', true); //default false
define('LOG_FILE_COMMON', 'common');
define('LOG_NAME_COMMON', 'common');
define('LOG_FILE_CUSTOMERS', 'customers');

define('LOG_FILE_DAYS_LIMIT', 3); //Сколько дней лога хранить

define('AMO_LONG_TOKEN', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjM4ZDNhZTljMDQyM2VmZjM2NTQ1NTQ0YWQ1ZTNkOTFiN2I3MTEyZTY5YTY2YWFhOWVmNjk2YzkxNTcwODQ1NDg2MmJiNGM4YjU3YTA3OGQ5In0.eyJhdWQiOiJiMzhlY2VjZi0xMTQ5LTQ2OTAtOWY0Zi02MDRhZTM1YjRmZmEiLCJqdGkiOiIzOGQzYWU5YzA0MjNlZmYzNjU0NTU0NGFkNWUzZDkxYjdiNzExMmU2OWE2NmFhYTllZjY5NmM5MTU3MDg0NTQ4NjJiYjRjOGI1N2EwNzhkOSIsImlhdCI6MTc1Njc2NDc5MCwibmJmIjoxNzU2NzY0NzkwLCJleHAiOjE5MTQ0NTEyMDAsInN1YiI6IjMyMjY5MCIsImdyYW50X3R5cGUiOiIiLCJhY2NvdW50X2lkIjo4MTE4MDY0LCJiYXNlX2RvbWFpbiI6ImFtb2NybS5ydSIsInZlcnNpb24iOjIsInNjb3BlcyI6WyJjcm0iXSwidXNlcl9mbGFncyI6MCwiaGFzaF91dWlkIjoiMzliMWM5N2QtMzZmYS00ZmRmLWJlNTctMjM3N2EzMWE5OTM2IiwiYXBpX2RvbWFpbiI6ImFwaS1iLmFtb2NybS5ydSJ9.FvVFkZwndOvQjSLj1yEgBlAP1Gz-ShEJFAydTwyUM9PZ7Hoyn8Pl9RIdG3nFw7vQ4RjlkHe8bbn5YISzsEjO-yV3Oy3uPBb3AdIHAxNtftQ_MLA1yMv3lDWYBcvaYghJkyD1q-yzUoFJX0VHqfpCymscPR7Hft5oS7Ft7lA0iUSxiv9KRIERXZkXPA4A2tN2f4TMh7ehg7ZIuHRKIUl_BwytWjYfSAI879k1TQwqcAZx4UbIBy7aIydHbWkU7oEq0sPi5USjlg6e-OaKSVmJOrgmO3ZZ5LDTgPHjIJRxOOCNuhawLO1wbxuCp8vnnNH9lDY2pgEm6pv84R6qzVNyFQ');

define('AMO_SECRTET', '');
define('AMO_CLIENT_ID', '');
define('AMO_REDIRECT_URL', '');
define('AMO_BASE_DOMAIN', 'jewell.amocrm.ru');
define('AMO_CODE', '');

define('AMO_TOKEN_FILE', DIR_TOKEN . DS . 'token.json');

//Сколько ждать после обращения к новой странице
define('AMO_TIMEZONE', 'Europe/Moscow');
define('AMO_PAGINATION_WAIT_SEC', 1);

define('AMO_BIRTHDAY_FIELD_ID', 2022509);
define('AMO_AGE_FIELD_ID', 2022267);
define('AMO_HEBREW_FIELD_ID', 1772227);

