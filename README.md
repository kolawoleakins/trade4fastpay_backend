# API For Trade4FastPay Project

**Note: _The Api Was Versioned by Storing the Controllers in a Route folder and
adding a url prefix of V1_.**

## Routes available :

**Note: _Base API URL = https://trade4fastpay.herokuapp.com, or any base route
created by your local machine or remote host._**

### Routes for Unauthorized Users.

-   Register User : https://trade4fastpay.herokuapp.com/api/V1/register
-   Send mail verification : https://trade4fastpay.herokuapp.com/api/V1/send-verify-mail/{email}
-   Forgot password : https://trade4fastpay.herokuapp.com/api/V1/forgot-password/{email}
-   Reset password : https://trade4fastpay.herokuapp.com/api/V1/reset-password/{token}

### Routes for Authorized Users only

-   Logout : https://trade4fastpay.herokuapp.com/api/V1/logout

### Trade Routes

**Note: _Trades can only be made by an authorized user (user with a token)
and the trades made are only available to that particular user that has
been authorized after login_**

-   trade(GET method) : https://trade4fastpay.herokuapp.com/api/V1/trade (fetch all the trade for the authorized user)
-   trade (POST method) : https://trade4fastpay.herokuapp.com/api/V1/trade (creates a trade for the particular authorized user)
-   trade-show (GET method) : https://trade4fastpay.herokuapp.com/api/V1/trade/{id} (shows a trade with an id of the value specified where {id} is. user for the particular authorized user)
-   trade-delete (DELETE method) : https://trade4fastpay.herokuapp.com/api/V1/trade/{id} (delete the trade made )
    api/V1/trade/1

### Presumed Work Flow for registration and login

-   When a user comes then sign in.
-   after sign in a verification link is sent which they click to verify their mail
-   Then are told to login
-   After login they get authorized (by being assigned a token)
-   With the token the can now access the trade functionality
-   As only authorized users should be able to trade coin(or so)

### Presumed Work Flow for password forget and reset

-   Enter the mail (my back end code check if the mail actually belongs to a user)
-   If yes for above then the mail is sent to the mail inserted in the form field
-   finally the password is changed

### JSON Response Structure not confirmed yet
