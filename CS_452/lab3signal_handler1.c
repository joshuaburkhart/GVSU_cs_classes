/* 	
	Joshua Burkhart, Greg Braman
	10/1/2010
	Dr. Hans Dulilmarta
	CS 452
 _______  ___   ___      _______  _______ 
|       ||   | |   |    |       ||       |
|    ___||   | |   |    |    ___||  _____|
|   |___ |   | |   |    |   |___ | |_____ 
|    ___||   | |   |___ |    ___||_____  |
|   |    |   | |       ||   |___  _____| |
|___|    |___| |_______||_______||_______|

 _______  ___   _______  _______  _______ 
|       ||   | |       ||       ||       |
|    _  ||   | |    _  ||    ___||  _____|
|   |_| ||   | |   |_| ||   |___ | |_____ 
|    ___||   | |    ___||    ___||_____  |
|   |    |   | |   |    |   |___  _____| |
|___|    |___| |___|    |_______||_______|

 _______  ___   _______  __    _  _______  ___      _______ 
|       ||   | |       ||  |  | ||   _   ||   |    |       |
|  _____||   | |    ___||   |_| ||  |_|  ||   |    |  _____|
| |_____ |   | |   | __ |       ||       ||   |    | |_____ 
|_____  ||   | |   ||  ||  _    ||       ||   |___ |_____  |
 _____| ||   | |   |_| || | |   ||   _   ||       | _____| |
|_______||___| |_______||_|  |__||__| |__||_______||_______|

*/

#include <stdio.h>
#include <stdlib.h>
#include <signal.h>
#include <unistd.h>

void sig_handler (int); /* prototype */
void reset_sigint (void);
void waste_time (void);

pid_t who; //storing the result of fork
int chldcount,lead[2],chpid; //storing the child count and pipe

int main (void){
    struct sigaction act;
    chldcount = 0;//initially no children exist
    pipe(lead);
    printf ("This is process %d\n", getpid());
    /* set up a signal handler */
    act.sa_handler = sig_handler;
    sigemptyset (&act.sa_mask);
    act.sa_flags = 0;
    sigaction (SIGUSR1,&act, NULL);
    sigaction (SIGCHLD,&act, NULL);
    sigaction (SIGINT, &act, NULL);

    while (1) {
        pause();           /* blocked until signalled */
    }//end while
    return 0;
}//end main function

void sig_handler (int num){
    switch (num)
    {
	case SIGUSR1:
			who = fork();
			if(who){ //if this is the parent
				chldcount++;
			}//end if	
			else{ //if this is the child
				waste_time();
			}//end else
			break;
	case SIGCHLD:
			read(lead[0],&chpid,sizeof(int));
			printf("Parent %d: Child %d terminated...\n",getpid(),chpid);
			chldcount--;
			break;
        case SIGINT:
			if(!who){ //if this is the child
				chpid = getpid();
				printf("Child %d: terminating...\n",chpid);
				write(lead[1],&chpid,sizeof(int));
				exit(0);
			}//end if
            		else if(!chldcount){ //if no children exist
           			printf ("Parent %d: terminating...\n",getpid());
            			exit (0);
			}//end else if
			else{
				printf("Parent %d: %d children running. Cannot terminate.\n",getpid(),chldcount);
			}//end else
    }//end switch
}//end sig_handler function

void waste_time(){
	int k = 0,p = getpid();
	while(1){
		printf("Child %d: counter %d\n",p,k);
		k++;
		sleep(3);
	}//end while
}//end waste_time function
