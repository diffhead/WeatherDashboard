# WeatherDashboard
***

### Project Architecture and Concepts

Project developed by simplest MVC pattern implementation
with the modules structure of the project's components. Model
and Database relation described by ActiveRecord pattern.

### Application structure
1. **cache/** - dir for caching
2. **cache/file/** - cache files provided by Cache with the flag Cache::FILE
3. **cache/twig/** - default twig cache dir 
4. **Cli/** - classes for working over cli php 
5. **composer.json**
6. **config.json** - application configuration
7. **containers.json** - DependencyInjection container configuration
8. **Config/** - classes for App/Db/Memcached configs
9. **Core/** - project core
10. **create**-tables.sql - base migration for PostgreSQL
11. **Factories/** - contains abstract factory and other base factories
12. **frontend/** - frontend part of the application
13. **frontend/bundle** - bundled css js
14. **frontend/gulpfile.js**
15. **frontend/package.json**
16. **frontend/tsconfig.json**
17. **frontend/workspace/scss** - styles src 
18. **frontend/workspace/ts** - typescript src 
19. **Interfaces/** - project base interfaces
20. **Lib/** - project lib wrappers like the Twig/Memcached
21. **main.php** - entry point
22. **Models/** - base models
23. **Modules/** - modules dir for modules which will implement business logic and other algos separated from Core
24. **Services/** - project services
25. **SQLite/** - sqlite databases if they are needed
26. **static/** - static content
27. **templates/** - base app templates like an error.tpl
28. **Views/** - base project views
29. **Web/** - classes for working with web 
30. **Web/Controller/** - contains base Error and Redirect controllers

### Application execution looks like this:

1. **main.php** - is entry point, which executes **Loader** and calls **Loader::bootstrap** method.

2. **Loader::bootstrap** processing calling inited **Application** instance and **Application::initModules** if **_ENABLE_MODULES_** const equals true then **Application::run** method with passing **ApplicationRequest** into it.

3. **Appliction::run** processing calling the **Router** for giving current request's **Controller**, then running **Controller::init** and **Controller::execute** 
with passing the request data which been taken by calling **ApplicationRequest::getRequestData**. After the controller execution 
, algo calls **Controller::getView** method for taking the **View** and
do **View::display** and it will echo view's data which will be bufferized. 
Finally runs **Display::echo** and it will push bufferized content into the output.

### Application extending

According to the general concept, the developer should not touch the base files in the root directory, he needs to create a new module and work in its directory with
only by using base class calls and extending them in the module's namespace.

The great example is WebFrontend module which renders all base pages like - Index, Login, Sign Up, Admin etc.
