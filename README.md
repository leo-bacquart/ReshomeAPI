# Setup API
## Bind correct values : 
Set in ``docker-compose.yml`` :
```yaml
  nginx:
    image: nginx:latest
    ports:
      - "your_value"
```
Set in ``src/Database/database.yml``
```yaml
database:
  address: database_address
  user: database_user
  password: database_password
```

## Build Docker Images :
Run in directory root : 
```bash
docker-compose build
```

## Run Docker Images : 
Run in directory root :
```bash
docker-compose up -d
```
