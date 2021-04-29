# API V1 Documentation

## Credentials
- Get new authorization token `POST /api/v1/login` using the following credentials:
    - ***username:*** admin@example.com
    - ***password:*** 12345678

## Menus Endpoints
- List all menus: `GET /api/v1/menus`.
- Retrieve a single menu: `GET /api/v1/menus/{id}`, replace `{id}` with the actual menu id.
- Create a new menu: `POST /api/v1/menus`.
- Update menu: `PUT /api/v1/menus/{id}`, replace `{id}` with the actual menu id.
- Delete menu: `DELETE /api/v1/menus/{id}`, replace `{id}` with the actual menu id.

## Categories Endpoints
- List all categories: `GET /api/v1/categories`.
- Retrieve a single category: `GET /api/v1/categories/{id}`, replace `{id}` with the actual category id.
- Create a new category: `POST /api/v1/categories`.
- Update category: `PUT /api/v1/categories/{id}`, replace `{id}` with the actual category id.
- Delete category: `DELETE /api/v1/categories/{id}`, replace `{id}` with the actual category id.

## Items Endpoints
- List all items: `GET /api/v1/items`.
- Retrieve a single item: `GET /api/v1/items/{id}`, replace `{id}` with the actual item id.
- Create a new item: `POST /api/v1/items`.
- Update item: `PUT /api/v1/items/{id}`, replace `{id}` with the actual item id.
- Delete item: `DELETE /api/v1/items/{id}`, replace `{id}` with the actual item id.
- Upload image: `POST /api/v1/items/{id}/image`, upload image file and attach it to item.
- Delete image: `DELETE /api/v1/items/{id}/image`, delete image file and detach it from item.

## Sorting
To sort the results, just pass `sort` query parameter with either `asc` or `desc` values when sending `GET` requests to fetch all resources, for example: `GET /api/v1/items?sort=asc`.
