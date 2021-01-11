Portal for Booking Cab user can book cab and manage there profiles admin will have to approve users after the user have created there ID Create a MIS application using PHP, MySql, HTML, CSS & JS use OOPS concept Do not use Bootstrap

User Group 1(Customer)-

1- Can signup / login 2- Can Book Taxi 3- Can check previous ride with proper date & price & Other information 4. Can check how much he spent on cab 5. Can filter data like month wise , week wise 6. Can sort data(by ride date , by fare) 7. Only unblocked user can login 8. Can update personal information like mobile number, Password, Name, username can't change

Group 2 (Admin)

Can check new ride request
Can approve and cancel request
Can see Invoice of all the customers
Can block & unblock user
Can delete ride information
Can check total past ride details.
Can check total earnings.
Can sort data by name, by date , by total fare
There will be default account with login id password for admin
Can view, add location & distance from charbagh , can edit, delete the available route
Note:- Maintain Session, Cookies (for back to user like facebook)


Schema -
tbl_user
user_id int PK AI, user_name unique name varchar, dateofsignup varchar / datetime, mobile varchar, isblock boolean, // 0 for blocked 1 for unblocked password varchar md5(), is_admin Boolean
default user :- username- harsh , password- 123

tbl_ride
ride_id int PK AI, ride_date date, from varchar, to varchar, total_distance varchar, luggage varchar, total_fare varchar, status int, // 1 for pending , 2 for complete & 0 for cancelled customer_user_id varchar FK,
tbl_location
id int PK AI, name varchar, distance varchar, is_available boolean

Note: - Customer will have two area: Front-end for cab booking backend for data interpretation & login page is common for admin & user admin will have only backend area

Can book cab only after signing in anonymous user can't book Cab.


