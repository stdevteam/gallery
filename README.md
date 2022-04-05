GALLERY
=======



-----------------
Development setup
-----------------

Installing dependencies
    
    $ cd <path_to_project>/gallery/
    $ composer update

Creating the Database Tables/Schema

    $ cd <path_to_project>/gallery/
    $ php bin/console doctrine:schema:update --force
    
Running the development test server

    $ cd <path_to_project>/gallery/
    $ php bin/console server:run
    
Check in browser via http://localhost:8000/ link 
