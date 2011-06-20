D:
cd \utilities\PhpDocumentor\

REM delete the current docs directory content
REM rd /s d:\websites\cohere-web\help\code-doc\
REM md d:\websites\cohere-web\help\code-doc\


REM use the line below to generate the docs for the site
REM phpdoc -d d:\websites\cohere-web\phplib\ -t d:\websites\cohere-web\help\code-doc\ -tb d:\websites\cohere-web\_util\phpdoctemplates

REM use this line to just generate the docs for apilib.php
phpdoc -f d:\websites\cohere\phplib\apilib.php -t d:\websites\cohere\help\code-doc\ -tb d:\websites\cohere\_util\phpdoctemplates -dn "Cohere-API"
