# Aplicación para la selección española de basket

Proyecto demo implementando DDD y arquitectura hexagonal sobre Symfony 5

## Instalación

Instalamos las dependencias de componser:

    composer install
    
## Test 

Para lanzar los test de phunit:

    composer test

## Uso de la aplicación


Se trata de una aplicación de consola, con lo que realizaremos toda la interactuación mediante la consola de Symfony 


### Añadir nuevos usuarios

    ./bin/console basket:player:add --help
    Description:
      Add new player to the app
    
    Usage:
      basket:player:add <number> <name> <role> <score>
    
    Arguments:
      number                The player number, its identifier
      name                  The player name
      role                  The player preferred role, it should be BASE, ESCOLTA, ALERO, ALA-PIVOT, PIVOT
      score                 The average trainer score
      

Un ejemplo sería algo así:

    ./bin/console basket:player:add 87 'Oscar ESTEVE' BASE 100

Añadir usuarios uno a uno puede resultar muy aburrido, podemos utilizar los datos de ejemplo que proporciona la aplicación para tener algo de contenido:

    ./bin/console basket:player:sample
    
Si queremos resetear las bases de datos podemos utilizar el siguiente comando, eliminará todo el contenido almacenado:

    ./bin/console basket:system:clear

### Listar usuarios

Podemos lista los usuarios dados de alta en la plataforma, ordenándolos por dorsal o por puntuación:

    ./bin/console basket:player:list --help
    Description:
      List the full list of players
    
    Usage:
      basket:player:list [<sort>]
    
    Arguments:
      sort                  sort option dorsal|puntuacion [default: "dorsal"]

De forma predeterminada utilizará el dorsal, con lo que veremos el listado por el identificador de jugador con:

    ./bin/console basket:player:list
    
Si queremos el listado por puntuación:

    ./bin/console basket:player:list puntuacion
    
### La alineación perfecta

Disponemos de una serie de alineaciones en la plataforma:
 - Defensa 1-3-1
 - Defensa Zonal 2-3
 - Ataque 2-2-1
 
Para cada una de ellas podemos obtener la alineación que más se ajusta en función de las puntuación media de cada jugador:

    ./bin/console basket:alignment:generate --help
    Description:
      Generate an alignment from tactic name
    
    Usage:
      basket:alignment:generate <tactic>
    
    Arguments:
      tactic                The tactic name

Ojo con los espacios, tenemos que añadir comillas, por ejemplo:

    ./bin/console basket:alignment:generate 'Defensa 1-3-1'
    ./bin/console basket:alignment:generate 'Defensa Zonal 2-3'
    ./bin/console basket:alignment:generate 'Ataque 2-2-1'

### Historico de eventos

Cada modificación en la plataforma genera unos eventos, estos son registrados para poder realizar tareas adicionales en
el futuro:

    ./bin/console basket:events:list --help
    Usage:
      basket:events:list [<position>]
      basket:events:list List all stored events
    
    Arguments:
      position              event offset position [default: "0"]
    
Podemos ver todo lo que ha acontecido en la plataforma con:
    
    ./bin/console basket:events:list
    
Tambien podemos obtener solo los eventos desde la última vez que los consultamos utilizando la posición: 

    ./bin/console basket:events:list 5