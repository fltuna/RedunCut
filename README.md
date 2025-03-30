
# Backend

## Public Endpoint

GET: `/api/v1/redirect/{short_code}`

### Example Resnpose

```json
{
	"original_url": "https://example.com/very/long/path/that/needs/to/be/shortened"
}
```


## Request schema

## Create User

POST: `/api/v1/register`

```json
{
    "name": "テストユーザー",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```


## Login

POST: `/api/v1/login`

```json
{
    "email": "test@example.com",
    "password": "password123"
}
```

## Logout

POST: `/api/v1/logout`

No body required.

## Create Shorten URL

POST: `/api/v1/urls/`

### With custom short code

```json
{
  "original_url": "https://example.com/very/long/path/that/needs/to/be/shortened",
  "short_code": "example123"
}
```

### Without custom short code

```json
{
  "original_url": "https://example.com/very/long/path/that/needs/to/be/shortened",
}
```

#### Example Response

```json
{
	"id": 1,
	"original_url": "https://example.com/very/long/path/that/needs/to/be/shortened",
	"short_code": "example123",
	"short_url": "http://localhost:8000/s/example123",
	"created_at": "2025-03-28T21:49:04.000000Z"
}
```

---

## Query shorten URL

GET: `/api/v1/urls/{ID]`

### Example response

```json
{
	"id": 2,
	"original_url": "https://example.com/very/long/path/that/needs/to/be/shortened",
	"short_code": "example12356aaa",
	"short_url": "http://localhost:8000/s/example12356aaa",
	"expires_at": null,
	"clicks": 0,
	"created_at": "2025-03-28T21:55:23.000000Z",
	"updated_at": "2025-03-28T22:01:06.000000Z"
}
```



## Update Shorten URL

PUT/PATCH: `/api/v1/urls/{ID}`

```json
{
  "original_url":"https://example.com/very/long/path/that/needs/to/be/shortened",
  "short_code": "example123"
}
```

### Example response

```json
{
	"id": 1,
	"original_url": "https://example.com/very/long/path/that/needs/to/be/shortened",
	"short_code": "example123",
	"short_url": "http://localhost:8000/s/example123",
	"expires_at": null,
	"clicks": 0,
	"created_at": "2025-03-28T21:49:04.000000Z",
	"updated_at": "2025-03-28T21:51:03.000000Z"
}
```



## Delete shorten URL

DELETE: `/api/v1/urls/{ID}`

Send request without body

### Example response

```json
{
	"message": "Resource Deleted"
}
```