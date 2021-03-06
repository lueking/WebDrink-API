WebDrink API v2
===============

Parameter | Value
---|---
api_key | Your API key

To make an API call, format your request like this:

`https://webdrink-api.csh.rit.edu/v2/<route>?<parameters>`

### It's not the same as the old one!
v2 of the API closely follows the existing one in WebDrink-2.0, but is not identical. Certain things have changed. **This is not an exact port of the v1 API from WebDrink-2.0!**
Follow the documentation below to see what has changed.

----------------------------------


#### Test
* [GET /test](#get-test) - Test the API 
* [GET /test/auth](#get-testauth) - Test the API with SSO/OIDC authentication (Auth only)
* [GET /test/api/{api_key}](#get-testapiapi_key) - Test the API with API key authentication (API key only)

#### Users
* [GET /users/credits/{uid}](#get-userscreditsuid) - Get a user's drink credit balance (drink admin only if :uid != your uid)
* [POST /users/credits/{uid}/{value}/{type}](#post-userscreditsuidvaluetype) - Update a user's drink credit balance (drink admin only)
* [GET /users/search/{uid}](#get-userssearchuid) - Search for usernames that match the search :uid
* [GET /users/info/{uid}/{ibutton}](#get-usersinfouidibutton) - Get a user's info (uid, username, common name, credit balance, and ibutton value)
* [GET /users/drops/{limit}/{offset}/{uid}](#get-usersdropslimitoffsetuid) - Get the drop logs for a single or all users
* [GET /users/apikey](#get-usersapikey) - Get your API key
* [POST /users/apikey](#post-usersapikey) - Generate a new API key for yourself
* [DELETE /users/apikey](#delete-usersapikey) - Delete your current API key

#### Machines
* [GET /machines/stock/{machine_id}](#get-machinesstockmachine_id) - Get the stock of all or a single drink machine
* [GET /machines/info/{machine_id}](#get-machinesinfomachine_id) - Get the info for one (or all) drink machine
* [POST /machines/slot/{slot_num}/{machine_id}/{item_id}/{available}/{status}](#post-machinesslotslot_nummachine_iditem_idavailablestatus) - Update a slot in a drink machine (drink admin only)    

#### Items
* [GET /items/list](#get-itemslist) - Get a list of all drink items
* [POST /items/add/{name}/{price}](#post-itemsaddnameprice) - Add a new drink item (drink admin only)
* [POST /items/update/{item_id}/{name}/{price}/{status}](#post-itemsupdateitem_idnamepricestatus) - Update an existing drink item (drink admin only)
* [POST /items/delete/{item_id}](#post-itemsdeleteitem_id) - Delete a drink item (drink admin only)

#### Temps
* [GET /temps/machines/{machine_id}/{limit}/{offset}](#get-tempsmachinesmachine_idlimitoffset) - Get temperature data for a single drink machine

#### Drops
* [GET /drops/status](#post-dropsstatus) - Check the Websocket connection to the drink server
* [POST /drops/drop/{ibutton}/{machine_id}/{slot_num}/{delay}](#post-dropsdropibuttonmachine_idslot_numdelay) - Drop a drink by machine id and slot number, using the specified delay.

#### MobileApp
* [GET /mobileapp/getapikey](#get-mobileappgetapikey) - Get (or generate) a user's API key from a WebDrink mobile app


-----------------------------------



## Test

### GET /test

**Description:** Test the API.

**Parameters:** None.

**Sample Response:** 
```json
{
    "status": true,
    "message": "Greetings from the Drink API!",
    "data": true
}
```

### GET /test/auth

**Description:** Test the API using SSO/OIDC authentication (Auth only)

**Parameters:** None

**Sample Response:**
```json
{
    "status": true,
    "message": "Greetings, matted!",
    "data": true
}
```

### GET /test/api/{api_key}

**Description:** Test the API with API key authentication (API key only)

**Parameters:** None

Attribute | Value
----------|------
api_key | Your API key

**Sample Response:**
```json
{
    "status": true,
    "message": "Greetings, matted!",
    "data": true
}
```

## Users

### GET /users/credits/{uid}

**Description:** Get a user's drink credit balance (drink admin only if :uid != your uid)

**Parameters:** None

Attribute | Value
---|---
uid | Username of the user

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/users/credits)",
    "data": 817
}
```

### POST /users/credits/{uid}/{value}/{type}

**Description:** Update a user's drink credit balance (drink admin only)

**Parameters:** None

Attribute | Value
---|---
uid | Username of the user
value | Amount of credits to add or subtract
type | Type of transaction,"add" or "subtract"

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/users/credits)",
    "data": 917
}
```

### GET /users/search/{uid}

**Description:** Search for usernames that match the partial :uid

**Parameters:** None

Attribute | Value
---|---
uid | (Partial) username of the user

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/users/search)",
    "data": [
        {
            "uid": "ben",
            "cn": "Ben Litchfield"
        },
        {
            "uid": "benjamin",
            "cn": "Benjamin Meyer"
        },
        {
            "uid": "benrr101",
            "cn": "Benjamin Russell"
        },
        {
            "uid": "bencentra",
            "cn": "Ben Centra"
        }
    ]
}
```

### GET /users/info/{uid}/{ibutton}

**Description:** Get a user's info, including uid, username, credit balance, and ibutton. Only requests by drink admins will return ibutton. Will return your own info if no uid or ibutton is provided.

**Parameters:** None

Attribute | Value
---|---
uid | Username of the user to look up (optional, admin only)
ibutton | ibutton of the user to look up (optional, admin only)

**Sample Response:**
```json
{
    "status": true,
    "message": "Success (/users/info)",
    "data": {
        "uid": "bencentra",
        "credits": "817",
        "admin": "1",
        "ibutton": REDACTED,
        "cn": "Ben Centra"
    }
}
```

### GET /users/drops/{limit}/{offset}/{uid}

**Description:** Get a history of drink drops

**Parameters:** None

Attribute | Value
---|---
limit | How many results to return (optional, default 100)
offset | How many results to skip (optional, default 0)
uid | The user to get the history for (optional, none will get drops for all users)

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/users/drops)",
    "data": [
        ...
        {
            "drop_log_id": 10479,
            "machine_id": 1,
            "display_name": "Little Drink",
            "slot": "2",
            "username": "zemon1",
            "time": "2013-11-14 00:52:02",
            "status": "ok",
            "item_id": 10,
            "item_name": "Sprite",
            "current_item_price": 50
        },
        ...
    ]
}
```

### GET /users/apikey

**Description:** Get your API key and the date it was generated (Webauth only).

**Parameters:** None

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/users/apikey)",
    "data": {
        "uid": "bencentra",
        "api_key": REDACTED,
        "date": "2014-09-27 23:25:43"
    }
}
```

### POST /users/apikey

**Description:** Generate a new API key, will overwrite your old one (Webauth only).

**Parameters:** None

**Sample Response:**
```json
{
    "status": true,
    "message": "Success (/users/apikey)",
    "data": {
        "uid": "bencentra",
        "api_key": REDACTED,
        "date": "2014-09-28 15:59:08"
    }
}
```

### DELETE /users/apikey

**Description:** Delete your API key. Must be called from WebDrink (or another client behind Webauth).

**Parameters:** None

**Sample Response:**
```json
{
    "status": true,
    "message": "Success (/users/apikey)",
    "data": true
}
```

## Machines

### GET /machines/stock/{machine_id}

**Description:** Get the stock of one or all drink machines, sorted by machine

**Parameters:** None

Attribute | Value
---|---
machine_id | The id of the drink machine (optional, none gets all machines)

**Sample Response:**
```json
{
    "status":true,
    "message":"Success (/machines/stock)",
    "data":{
        "2":[
            {
                "slot_num": 1,
                "machine_id": 2,
                "display_name": "Big Drink",
                "item_id": 74,
                "item_name": "Drink's Choicey Choice",
                "item_price": "50",
                "available": 1,
                "status": "enabled"
            },
            ...
        ]
    }
}
```

### GET /machines/info/{machine_id}

**Description:** Get the info for one or all drink machine

**Parameters:** None

Attribute | Value
---|---
machine_id | The id of the drink machine (optional, none gets info for all machines)

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/machines/info)",
    "data": [
        ...
        {
            "machine_id": 2,
            "name": "bigdrink",
            "display_name": "Big Drink",
            "alias_id": 2,
            "alias": "d"
        },
        ...
    ]
}
```

### POST /machines/slot/{slot_num}/{machine_id}/{item_id}/{available}/{status}

**Description:** Update a slot in a drink machine (drink admin only)

**Parameters:** None

Attribute | Value
---|---
slot_num | Slot number to update
machine_id | ID of the machine the slot is in
item_id | ID of the slot's new item (optional)
available | Amount of the item in the slot (optional)
status | Status of the slot, "enabled" or "disabled" (optional)

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/machines/slot)",
    "data": true
}
```


## Items

### GET /items/list

**Description:** Get a list of all drink items

**Parameters:** None

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/items/list)",
    "data": [
        ...
        {
            "item_id": 9,
            "item_name": "Coke",
            "item_price": "50",
            "state": "active"
        },
        ...
    ]
}
```

### POST /items/add/{name}/{price}

**Description:** Add a new drink item (drink admin only)

**Parameters:** None

Attribute | Value
---|---
name | The name of the item
price | The cost of the item

**Sample Response:** 
```json
{
    "status" :true,
    "message":" Success (/items/add)",
    "data": 93
}
```

### POST /items/update/{item_id}/{name}/{price}/{status}

**Description:** Update an existing drink item (drink admin only)

**Parameters:** None

Attribute | Value
---|---
item_id | The ID of the item
name | The new name of the item
price | The new cost of the item
status | The status of the item, "active" or "inactive"

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/items/update)",
    "data": 93
}
```

### POST /items/delete/{item_id}

**Description:** Delete a drink item (drink admin only)

**Parameters:** None

Attribute | Value
---|---
item_id | ID of the item 

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/items/delete)",
    "data": 93
}
```

## Temps

### GET /temps/machines/{machine_id}/{limit}/{offset}

**Description:** Get temperature data for a single drink machine

**Parameters:** None

Attribute | Value
---|---
machine_id | ID of the machine
limit | How many results to return (optional, default 300)
offset | How many results to skip (optional, default to 0)

**Sample Response:** 
```json
{
    "status": true,
    "message": "Success (/temps/machines)",
    "data": [
        ...
        {  
            "machine_id": 1,
            "time": {
                "date": "2018-01-18 15:30:19.000000",
                "timezone_type": 3,
                "timezone": "America\/New_York"
            },
            "temp": 76
        },
        ...
    ]
}
```

## Drops

### GET /drops/status

**Description:** Check the status of the Websocket connection to the drink server.

**Parameters:** None

**Sample Response:**

```json
{
    "status": true,
    "message": "Success! (/drops/status)",
    "data": true
}
```

### POST /drops/drop/{ibutton}/{machine_id}/{slot_num}/{delay}

**Description:** Drop a drink by machine ID and slot number, for a user identified by iButton, using a given delay

**Parameters:** None

Attribute | Value
---|---
ibutton | iButton number of the user dropping a drink
machine_id | ID of the machine (i.e. 1 for Little Drink)
slot_num | Slot number to drop a drink from
delay | The number of seconds to delay the drop (optional, defaults to 0)

**Sample Response:**

```json
{
    "status": true,
    "message": "Drink dropped!",
    "data": true
}
```

## MobileApp

### GET /mobileapp/getapikey

**Description:** Get (or generate) a user's API key from a WebDrink mobile app

**Parameters:** None

**Sample Response:**

On success, redirects back to the mobile app (cshdrink://auth/api_key_here). On error, returns JSON. 