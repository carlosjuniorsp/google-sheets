<?php

class Credentials
{
    public  function getCredencials()
    {

        $credenciais = [
            "type" => "service_account",
            "project_id" => "olyraintegracaosheets",
            "private_key_id" => "7f9b31b998142dd51f04467f14dfb70c79a06162",
            "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDIdceC9VoRW3F8\nsLTRk8czc9zXvZKvaZQYCy5U3bGxVwz45MUA50n2A3Uyz8FkJLrZMVpe/XYqx2IX\nDP1UhUKOAOBemjm5ceuYE7XeYQVd0ycHvM6n8lGLL15EvN+HVWbrOFWnliNcw1uz\n8kJ3n4oh5uUgpRhsq/Af6pGBKzdRgJdiN/w+HfnZ3fOoi7zDnfHtcwTklHtIvfh6\niRXHgMrwQNLJIyP/boIqLVhjeoi4JAemH+MyBAudfzMGL0/buzxXVbVwVIJlanck\nUipv7HVzW33QGEtvP+PNYlTAqq3jAdh2+GPhzJHPBfSiw1/+6ZOZSY1IgB8L1SY/\nj8GQwVjhAgMBAAECggEAAMytPKVPwnxL078ZWKMWTrIsN3xJk/xN+2gfkK755kpX\nF70KSo4FKI2lFqG8uB0kuPi1edef9GsrRdG1KoK+qmCpEqeFX4eWLXd9U0NYk/d/\n6ITTUYOboKb8xMP4wApD/jVmlvIivdwkDhqDMz4p0mB14O9Jae39Z8z130YSPbB4\nTSAi1Y/Jidsw6owtOq9Y4OzQmL9BqX4DzlNjLqYDYQ+8iLfxMFPovSMnC/qXfcPr\naRtTH521+7vg+H7uqttxcHn4wutDmLzc0EceLpXXUBhL6HgWMu/4Dd7bVaZX21ea\nN7d7XslUreQIIDDGWz4TqWIAPB5qUMbiib3pHcmYewKBgQDoUJMO7ywJZagDcxX8\ncbg/bfoNbnQoDEkROHmgvu09TolQh2hHI2DGldVvpIfMVXxZ/qE+sUhj9G4V1AlQ\nHJ88tHL+x6WG0yRojYUWazqVxj0DYg489SRQuFnDyfxG0p4F/pDyWzytZ8Up02to\n8IhvH8Grc8MhlDs7JwFYf0Ws0wKBgQDc5cvskhO9HQnRH+CBSQIJgVnEsMLUG6Mh\ny9rxixQLB0vYpluSiv7QQ6aRuV8YiHLWRd65IMCeI2g99v2hR2hRVJFM8CdSoD4e\nA07G8A0AcIH916eSnaLmpnNIDCmUsiMR30L1NSF5G2qQJ9uJkN26FoIbtwvlEQFC\n5g86vAPC+wKBgQCOxf4q/nhs6gng3NjVRbp7WQaFPK2scyhwqemuDcjVla+0SxOe\nLLLsOOdsbox62srKsD++vMuFipIhXie/EWgXsbq+tEoZWygUDW2OgqYFqEiVDK09\nb1c7OKEKP9eIWyZ8/p9sIwBefdjhRKrNWo4u5TBsQ3/X4jaouucL0WQruwKBgAQq\ngVIQ3zZt2cWL6FwH2HX9bof7HXGKo+T7R0HO8a3TkWagnJGC9ZNP81BEQrrft+q6\nnpy3NWrGGC0y/02PXzRJeAQPc25nf0Rpo4608EnV1V3IN2zYdD4NXZc6Q35+bZLk\ntwqQ2fTCw5u8ZLOPe98KlaGYLi0/yNpOJHNjIF8JAoGBAJ6SD4NXjQ1YOKIJdcx4\ne6KufEY9x51wzE10ixn3A1Hzf7YWm4fYu+kSSx2j0hLXkeyN7rFGUNCXWC4SS30r\noy63JtHLZ+B6qsQZoobxtGxSc/z6QSmHR0yv33fnWnf1GQVSAQPoV6YmY6kOSaTs\nRrQi79nil+pj7lE4PYbdXfvv\n-----END PRIVATE KEY-----\n",
            "client_email" => "credencial-sheets-php@olyraintegracaosheets.iam.gserviceaccount.com",
            "client_id" => "107191991710196626569",
            "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
            "token_uri" => "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/credencial-sheets-php%40olyraintegracaosheets.iam.gserviceaccount.com",
            "universe_domain" => "googleapis.com"
        ];

        return $credenciais;
    }
}

new Credentials;