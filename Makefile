up:
	docker-compose up -d

down:
	docker-compose down

logs:
	docker logs $(IMAGE_NAME)
