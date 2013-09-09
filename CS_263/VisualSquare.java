import java.util.Scanner;


/**
 * This class was written for a CS 263 programming assignment.
 * It finds the least number of sub squares that can fit inside
 * a main square so long as:
 * (maximum sub square size == (main square size - 1))
 * This program was not designed to handle very large squares 
 * and takes some time doing large primes.
 * 
 * @author Joshua Burkhart
 * @date 11/18/2009
 *
 */
public class VisualSquare {
	
	//global variables that help keep track of square solution
	private int[] squareSolution;
	private int[] maxSquareSize;
	private int[] squareInProgress;
	private int[] nums;
	private int   lowestCount;
	private int   mainSquareSize;
	
	 
	/**
	 * A constructor that shows a welcome message and instantiates a 
	 * Scanner object allowing user input. The constructor also checks
	 * the input for errors, ie: invalid characters.
	 */
	public VisualSquare() {
			//variable that helps the program take input
			boolean working = true;
			
			//welcome screen
			System.out.println("******WELCOME TO JOSHUA BURKHART'S 263 SQUARE SOLVER*******");
			System.out.println("***********ENTER THE SIZES OF YOUR SQUARES BELOW***********");
			System.out.println("*********TYPE 'HELP' FOR A LIST OF VALID COMMANDS**********");
			
			//while loop that continues to scan for input
			while(working) {
				
				Scanner scan = new Scanner(System.in);
				String n = scan.nextLine();
				
				if(n.equals("exit")) {
					System.out.println("System Exiting...");
					working = false;
				}//end if
				else if((n.equals("help")) || (n.equals("HELP"))){
					System.out.println("VALID COMMANDS: '[square size]', 'exit', 'help', HELP");
					System.out.println("TO USE THIS PROGRAM: ENTER THE NUMBER OF SQUARES FOLLOWED BY EACH SQUARE SIZE");
					System.out.println("EXAMPLE: '3793' REPRESENTS 1 SQUARE OF SIZE 3793 * 3793");
				}//end else if
				else {
					
					//try to process the input
					try {
						//call to parseInt() that converts scanned
						//input into an integer and checks for number
						//format exceptions
						int check = Integer.parseInt(n);
						
						//for loop that begins solving
							startSquare(check);
						
						
					}//end try
					catch(NumberFormatException nf) {
						System.out.println("'" + n + "' is an invalid command." +
								" This program accepts only integers as input." +
								" Example: '3351'.");
					}//end catch
				}//end else
			}//end while loop
			//----------------for testing-------------------
			//System.out.println("CONSTRUCTOR FINISHED");
		}//end Square constructor

	/**
	 * A method that begins the process of calculating the minimum squares
	 * needed to fill a larger square. It initializes some helpful variables, etc.
	 * 
	 * @param squareSize -the size of the square to be solved
	 */
	public void startSquare(int squareSize) {

		//set the values of the global variables
		int area = (int) Math.pow(squareSize, 2);
		mainSquareSize = squareSize;
		squareInProgress = new int[area];
		nums = new int[squareSize];
        squareSolution = new int[area];
        maxSquareSize = new int[area];
        
        //loop that resizes maxSquareSize
        for(int h = mainSquareSize, k = 0; h > 0; h--) {
            for(int j = mainSquareSize; j > 0; j--, k++) {
            	if(j < 1) {
            		maxSquareSize[k] = j;
            	}//end if
            	else {
            		maxSquareSize[k] = h;
            	}//end else
            }//end for
        }//end for
        
        //set the lowest count
        lowestCount = squareInProgress.length;
        
        //find the solution to the square
        findSolution();
        
        //print the solution
        printArray(squareSolution);
        
	}//end method
   
	/**
	 * A method that finds solutions to a single square problem
	 * and stores that solution in the global int[] 'squareSolution'
	 */
    private void findSolution() {
    	//where to start placing smaller squares
    	int idealStart;
    	
    	//if mainSquareSize is even
    	if(mainSquareSize % 2 == 0) {
    		//start in the middle
    		idealStart = (mainSquareSize / 2);
    	}//end if
    	else {
    		//start 1 unit beyond the middle
    		idealStart = (mainSquareSize / 2) + 1;
    	}//end if
    	
    	//for loop that places sub squares
        for(int i = idealStart; i < mainSquareSize; i++) {
        	
        	//biggest sub square
            placeSquare(i,0);
            
            placeSquare(mainSquareSize - i,i);
            placeSquare(mainSquareSize - i, i * mainSquareSize);
            
            //place other sub squares recursively
            nextPlacements(mainSquareSize * (mainSquareSize - i) + i, 3);
            
            
            placeSquare(mainSquareSize - i, i * mainSquareSize);
            placeSquare(mainSquareSize - i, i);
            placeSquare(i, 0);
        }//end for
    }//end method
   
    /**
     * A method that places integers in the squareInProgress 
     * that indicate a sub square placement
     * 
     * @param size  -the size of the sub square
     * @param place -the place in the squareInProgress
     */
    private void placeSquare(int size,int place) {
    	//if the place in squareInProgress is a zero
        if(squareInProgress[place] == 0) {
        	//increment size
        	nums[size]++;
         } //end if
        //otherwise
        else {
        	//decrement size
        	nums[size]--;
         }//end else
        
        //now go through
        for(int i = size; i > 0; i--, place += mainSquareSize) {
        	
        	//replace zeros with 'size'
        	if(squareInProgress[place] == 0) {
        		squareInProgress[place] = size;
        	}//end if
        	//replace 'size' with zeros
        	else {
        		squareInProgress[place] = 0;
        	}//end else
        }//end for
    }//end method
    
    /**
     * A method that places the rest of the squares.
     * 
     * @param place -location of next sub square placement
     * @param numSubSquares -number of sub squares in progress
     */
    private void nextPlacements(int place,int numSubSquares) {
    	
        int c1 = numSubSquares + 1;
        int c2 = c1 + 1;
        
        for(int i = maxSubSquare(place); i > 0; i--) {
            //Don't allow more than 5 squares of same size to be placed.
            if(nums[i]<5) {
                placeSquare(i,place);
                
                //Find the next available point to place a square.
                int next = nextPlacementLocation(place);
                
                if(next>=squareInProgress.length) {//We completed placing all squares. We have a solution, but may not be minimal.
                    lowestCount = c1; //Save the current amount of placed squares in bestCount.
                    //Save new solution
                    for(int j=squareInProgress.length - 1; j >= 0; j--) {
                        squareSolution[j] = squareInProgress[j];
                    }//end for
                    placeSquare(i,place);
                    return;
                }//end if 
                else if(c2 < lowestCount) {
                    //Not done placing squares.
                    nextPlacements(next,c1);
                }//end else if
                else {
                    placeSquare(i, place);
                    return;
                }//end else
                placeSquare(i, place);
            }//end if
        }//end for
    }//end method
   
    /**
     * A method that finds the maximum sub square size
     * at place
     * 
     * @param place -where to start
     * @return -the maximum sub square size
     */
    private int maxSubSquare(int place) {
        int max = maxSquareSize[place] + place;
        
        for(int i = place; i < max; i++) {
        	
            if(squareInProgress[i] != 0) {
                return(i - place);
            }//end if
        }//end for
        return(max - place);
    }//end method
   
    /**
     * A method that finds the next location that a 
     * sub square can be placed
     * 
     * @param place
     * @return -the next location a sub square can be placed
     */
    private int nextPlacementLocation(int place) {
    	//while place is smaller than the size of the square in progress
    	//and the indicator is not a zero
        while(place < squareInProgress.length && squareInProgress[place] != 0) {
        	//increment the place by the number indicated
        	//for example, if place was pointing at a '5',
        	//it would increment by 5 (the skipped places
        	//would still be zeros
        	place += squareInProgress[place];
        }//end while
        return(place);
    }//end method
    
    /**
     * A method that prints an array 'a'
     * 
     * @param a -the array to be printed
     */
    public void printArray(int[] a) {
    	//find the square size for the array
    	int size = (int) Math.sqrt(a.length);
    	int arraySize = a.length;
    	
    	//go through the array
        for(int i = 0; i < arraySize; i++) {
        	
        	if(i % size == 0) {
        		System.out.println();
        	}//end if
        		//print an indicating character and a space
        		System.out.print(" " + a[i]);
        	}//end for
        	System.out.println();
    }//end method
    
	/**
	 * The main method instantiates a new Square object
	 */
	public static void main(String[] args) {
		new VisualSquare();
	}//end main method
}