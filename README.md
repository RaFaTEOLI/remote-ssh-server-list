# Remote SSH Server List
 
<h2>About</h2>
Execute a command on many servers all at once.

Through this PHP program using phpseclib you can execute a command on many servers all at once , without having to connect to each one to perform such action.

![alt text](https://raw.githubusercontent.com/RaFaTEOLI/remote_ssh_server_list/master/remote_ssh_web.png)

In this project there are two PHP programs, one called remote_ssh.php, which is the pure code, where you can only set your command and execute it.

There is also another one called remote_ssh_web, where there is a web page to make it look better.

There is an SQL file where I wrote a script to create a table with the servers list and some fields to improve the connection, but if you have your own just replace your parameters on the mysql_conn/conn.php file.

Don't forget to change the parameters in order to open the connection with your servers.

<h4>Contact</h4>
If you want to get in touch with me here is my email: rafinha.tessarolo@hotmail.com

<h2>Versions</h2>

<h4>Version 1.0 added "ignore_server" field</h4>
If you want to ignore a server on the list just set the field ignore_server to 1 on servers table.

<h4>Version 1.0.1 added "use_rsa" field</h4>
There is a field called "use_rsa", set it 1 to use a key to access the server, and you must set the fields, "key_path" (with its location within your OS), and "key_passphrase" in order to authenticate using your key. 

<h4>Version 1.1 added configuration table</h4>
It was added a table for the database, that you can set some configurations, the first one is "stop_on_error", which means, if the program is executing commands on many servers and for some reason it catches an error it will stop on that server, only if it's set 1, otherwise it will keep going.
The other field is "ignoreServer_afterCmd", and this field if it's set 1, it will set the "ignore_server" field on the servers table after the program executes the command there, so if you run the program again, it will ignore the servers that you've already executed the command.
