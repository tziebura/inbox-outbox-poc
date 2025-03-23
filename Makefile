up:
	@docker compose up -d

bash:
	@docker compose exec php bash

order-create:
	@docker compose exec php bin/console app:order:create

consume-outbox:
	@docker compose exec php bin/console messenger:consume outbox -l1

setup-transports:
	@docker compose exec php bin/console messenger:setup-transports

consume-order-created:
	@docker compose exec php bin/console messenger:consume inventory.event.order_created -l1 --bus=event_bus -vv

schema-update:
	@docker compose exec php bin/console doctrine:schema:update --force