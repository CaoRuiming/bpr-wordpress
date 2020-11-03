up:
	docker-compose up -d

down:
	docker-compose down

logs:
	docker logs $(IMAGE_NAME)

sql-backup:
	docker exec -i bpr-mysql mysqldump -uwordpress -pwordpress --databases wordpress --skip-comments > backup.sql

sql-restore:
	docker cp backup.sql bpr-mysql:/backup.sql
	docker exec bpr-mysql /bin/bash -c 'mysql -uwordpress -pwordpress < /backup.sql'
