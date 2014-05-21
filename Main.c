#include <stdio.h>
#include <semaphore.h>
#include <pthread.h>
#include <string.h>
#include <stdlib.h>
#define n 10000
#define m 10
#define true 1

void* abejas(void* id); 
void* oso(); 

sem_t sem_abejas, sem_oso, exclusion_mutua; 

int tarro = 0 ; 


int main()
{
	int id;
	/**Inicializacion de los Semaforos**/  
	sem_init(&sem_abejas,0,1);/**Para que las Abejas puedan Producir Miel**/ 
	sem_init(&sem_oso,0,0); /**Para que el oso puedan Producir Miel**/ 
	sem_init(&exclusion_mutua,0,1);	/**Asegura la exlusion mutua**/ 
	/**Declaracion y Creacion de los Hilos**/
	pthread_t  hilo_abejas[10000], hilo_oso;
	pthread_create(&hilo_oso, NULL, oso, NULL);
	
	for(id=1;id<=n;id++) //creando las abejas
	{
		pthread_create(&hilo_abejas[id-1], NULL, abejas, (void*) &id);
		pthread_join(hilo_abejas[id-1], NULL);
	}
	
	pthread_join(hilo_oso, NULL);
	
	/**Destruccion de los Semaforos**/
	sem_destroy(&sem_abejas);
	sem_destroy(&sem_oso);	
	sem_destroy(&exclusion_mutua);
}

void* abejas(void* id){
	
	sem_wait(&sem_abejas);
	sem_wait(&exclusion_mutua);
		
	tarro++;
	
	
	printf("\nLa Abeja %d lleno el tarro %d Porciento\n",*(int *)(id),tarro*10);
	
	if (tarro < m)
	{
		sem_post(&sem_abejas); /**Como aun no lo he Llenado el Tarro le doy chance a otra Abeja**/
		
	}
	else/**Entonces el Tarro esta Lleno y Despierto al Oso**/
	{ 
		sem_post(&sem_oso);			
		
	}
	sem_post(&exclusion_mutua);

}

void* oso(){
	while (true){
		
	
	sem_wait(&sem_oso);
	sem_wait(&exclusion_mutua);
						
	tarro--;
	printf("\nEl Oso esta Comiendo, queda %d Porciento del Tarro de Miel\n",tarro*10);
	
	if (tarro > 0)
	{
		sem_post(&sem_oso);
	}
	else
	{
		printf("\nEl Oso se Acabo el Tarro de Miel y Ahora Duerme\n");
		sem_post(&sem_abejas);
	}
	
	sem_post(&exclusion_mutua);
	
	
	
	}
}
