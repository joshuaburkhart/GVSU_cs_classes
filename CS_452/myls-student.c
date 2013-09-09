/*
Joshua Burkhart
9/21/2010
Dr. Hans Dulimarta

This program implements the 'ls' function including the '-l' flag.

[Columns Implemented]
-the number of links
-the owner name
-the group name
-the file size
-the modification date
-the filename

Extra credit for this project was not attempted.
*/

#include <dirent.h>
#include <errno.h>
#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <unistd.h>
#include <pwd.h>
#include <grp.h>
#include <time.h>
#include <locale.h>
#include <langinfo.h>

/* declare function prototype(s) here */
int my_filter (const struct dirent *ent);

/* global variable(s) */
char cwd[PATH_MAX];

int main (int argc, char*argv[])
{
    /* A local variable to hold the address of an array of pointers to a
     * dirent structure */
    struct dirent** all_entry; 
    struct stat file;
    struct passwd *pw;
    struct group  *gp;
    struct tm     *tm;
    int num, k, l;

    /*--- check command line arguments ---*/
    if (argc > 1)
    {
        for (k = 1; k < argc; k++){
            if(strcmp(argv[k],"-l") == 0){
		l = 1;
	    }//end if
	}//end for
	if(l!=1){
	    printf("This implementation of 'ls' only understands '-l'\n");
	    return 0;
    	}//end if
    }//end if

    /*--- determine the current working directory ---*/
    if (! getcwd (cwd, PATH_MAX))
    {
        perror ("cwd buffer is too small");
        exit (errno);
    }//end if

    /*--- scan the current directory ---*/
    num = scandir (cwd, 
            &all_entry,  /* scandir internally allocates the array for us */
            my_filter,   /* run each entry thru a customized filter */
            alphasort);  /* sort the entries in alphabetical order */
    if (num < 0) {
        perror ("Fail to scan current directory");
        exit (errno);
    }//end if

    /*--- show the entries ---*/
    for (k = 0; k < num; k++){
        
        stat(all_entry[k]->d_name,&file);
	
	//if the 'l' parameter was specified this execution
	if(l==1){
		int ln,sz;
		char tm[256];

		//get owner name
		pw=getpwuid(file.st_uid);
		//get group name
		gp=getgrgid(file.st_gid);
		//get time of last modification
        	strftime(tm, sizeof(tm), nl_langinfo(D_T_FMT), localtime(&file.st_mtime));
		//get number of links
		ln=file.st_nlink;
		//get size of file
		sz=file.st_size;

        	printf("%-3d %-15s %-15s %-8d %s %s\n",ln,pw->pw_name,gp->gr_name,sz,tm,all_entry[k]->d_name);
	}//end if
	//'l' parameter was not specified for this execution
	else{
		printf("%s\n",all_entry[k]->d_name);
	}//end else
    }//end for

    /*--- free up the array elements internally allocated by scandir */
    for (k = 0; k < num; k++)
        free(all_entry[k]);
    free(all_entry);
    return 0;
}//end main function

/* The following function is just an example of how to customize the scandir
 * output to filter out small files (less than 700 bytes in size).
 * Unfortunately this filter will also (mistakenly) ignore directories */
int my_filter (const struct dirent *ent)
{
    struct stat my_info;
    char path[PATH_MAX];

    /* setup the absolute path of the directory entry */
    sprintf (path, "%s/%s", cwd, ent->d_name);
    lstat (path, &my_info);

    /* ignore files whose size is <= 700 bytes */
    if (errno == 0) { /* if lstat returns successfully */
        //return my_info.st_size > 700;
	return 1;
    }
    else {
        perror ("lstat error");
        return 0;
    }
}//end my_filter struct
