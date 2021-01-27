up:
	docker-compose up -d

down:
	docker-compose down

logs:
	docker logs bpr-wordpress

sql-backup:
	docker exec -i bpr-mysql mysqldump -uwordpress -pwordpress --databases wordpress --skip-comments --no-tablespaces > backup.sql

sql-restore:
	docker cp backup.sql bpr-mysql:/backup.sql
	docker exec bpr-mysql /bin/bash -c 'mysql -uwordpress -pwordpress < /backup.sql'
