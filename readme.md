# Document Managment System
A somewhat simple document management system for an organization or a medium-sized business with branches and departments based on the [Laravel](https://laravel.com/) PHP web framework `version 5.5` and [MySQL](https://www.mysql.com/) RDBMS `version 5.6`.

### Functionality
- Documents CRUD and file uploads
- Branches CRUD
- Departments CRUD
- Users CRUD plus others features like activating or deactivating accounts, changing passwords and granting or revoking admin rights

### To get started
1.  Create the database in mysql(**Note**: Make sure you have no database named `dms` in your mysql setup because it will be dropped, alternatively you can rename the database in the file `dms.sql` to something else)

    `mysql -u root -p < dms.sql`

2. Within the project root, create folder under the `public` called `static`, then under `static` create a folder called `uploads` after which the structure should look something similar to

    ```
    public
        ├── static
        │   └── uploads
    ```
		 
3. Create admin account by running `php artisan tinker`within the project root and then run the following statements
    ```
	>>> $salt = App\Library\Hash::salt()
    >>> $password = App\Library\Hash::make('YOUR_ADMIN_PASSWORD', $salt)

    >>> $user = new App\User
    >>> $user->username = 'YOUR_ADMIN_USERNAME'
    >>> $user->email = 'YOUR_ADMIN_EMAIL'
    >>> $user->salt = $salt
    >>> $user->passwd = $password 
    >>> $user->active = 1
    >>> $user->is_admin = 1
    >>> $user->save()
    ```