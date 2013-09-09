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
#include <errno.h>
#include <stdio.h>
#include <stdlib.h>
#include <signal.h>
#include <unistd.h>
#include <errno.h>

void sig_handler (int); /* prototype */
void reset_sigint (void);
void waste_time (void);
int pipe(int pd[2]);
int fork(void);
void error_exit(char *s);

pid_t who,chpid; //storing the result of fork
int chldcount; //storing the child count and pipe
int lead[2];

int main (void){
    struct sigaction act;
    chldcount = 0;//initially no children exist
    errno = 0;
    if(pipe(lead) == -1)
	error_exit("pipe() failed");
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
			if(who==0){ //if this is the child
				//close(lead[0]);
				waste_time();
			}//end if	
			else{ //if this is the parent
				//close (lead[1]);
				chldcount++;
			}//end else
			break;
	case SIGCHLD:
			if(read(lead[0],&chpid,sizeof(pid_t)) == -1)
				error_exit("read() failed");
			printf("Child %d terminated...\n", chpid);
			chldcount--;
			break;
        case SIGINT:
			if(who==0){ //if this is the child
				chpid = getpid();
				printf("Child %d terminating....\n",chpid);
				if(write(lead[1],&chpid,sizeof(pid_t)) == -1)
					error_exit("write() failed");
				exit(0);
			}//end if
            		else if(!chldcount){ //if no children exist
           			printf ("Parent %d terminating....\n",getpid());
            			exit (0);
			}//end else if
			else{
				printf("%d children still running. Cannot terminate.\n",chldcount);
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

void error_exit(char *s){
	printf("ERROR: %s with %d\n",s,errno);
	exit(1);
}//end error_exit function
