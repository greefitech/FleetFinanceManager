<!DOCTYPE html>
<html>
    <body>
        <h4>Welcome to Myvehicle</h4>
        <p>Hello {{ $client['name'] }},</p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;Thank you for registered with Myvehicle.biz</p>
        <i>User Registered Details:</i><br>
        <table border="1">
            <tbody>
                <tr>
                    <th>Transport</th>
                    <td>{{ $client['transportName'] }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $client['email'] }}</td>
                </tr>
                <tr>
                    <th>Mobile</th>
                    <td>{{ $client['mobile'] }}</td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td>Your Registered Password!</td>
                </tr>
            </tbody>
        </table><br>
        Your registered email-id is {{ $client['email'] }} , Please click on the below link to verify your email account
        <br/>
        <a href="{{ url('/client/verify', $client->verifyClient->token) }}">Verify Email</a>
        <br><br>
        <p><i><b>Note: </b></i><i>This email is generated from <a href="https://myvehicle.biz" target="_blank">MyVehicle Inc.</a></i> For Email Verification</p>
    </body>
</html>