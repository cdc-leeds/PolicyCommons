D:
cd \PhpDocumentor\

REM delete the current docs directory content
REM Don't do this if your are using Eclipse with svn as it will delete the svn folder and Eclipse will get upset.
REM Recommend you create to another folder, then replace the files afterwards and refresh Eclipse
REM rd /s d:\websites\cohere-web\help\code-doc\
REM md d:\websites\cohere-web\help\code-doc\


REM use the line below to generate the docs for the site
REM phpdoc -d d:\websites\cohere-web\phplib\ -t d:\websites\cohere-web\help\code-doc\ -tb d:\websites\cohere-web\_util\phpdoctemplates

REM use this line to just generate the docs for apilib.php
phpdoc -f D:\xampp\htdocs\cohere-website-v2\phplib\apilib.php -t D:\xampp\htdocs\cohere-website-v2\help\code-doc\ -tb D:\xampp\htdocs\cohere-website-v2\_util\phpdoctemplates -dn "Cohere-API"