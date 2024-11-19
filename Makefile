start:
	docker compose up -d

restart:
	docker compose restart

stop:
	docker compose down

shell:
	docker compose exec -it app bash

logs:
	docker compose logs -f

queues_start:
	docker compose exec app supervisorctl start laravel-worker:*

queues_stop:
	docker compose exec app supervisorctl stop laravel-worker:*

artisan:
	docker compose exec app bash -ci "php artisan $(filter-out $@,$(MAKECMDGOALS))"
