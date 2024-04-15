Caso seja direcionado a outro desenvolvedor esse projeto, se atentar ao necessitar migrar para novo banco do MONGODB:

Mover o arquivo de migração: 2024_04_11_193447_create_gpon_onuses_table.php
Para: database/migrations/

Para assim criar a tabela.

Atualmente foi necessário remover para que o comando de migração não afete a tabela de coletas, perdendo assim os dados já coletados. 
Em um novo ambiente, pode ser mantido o arquivo em "migrations", se ja não tiver sido criado o banco de outra forma. 
