func pivotInteger(n int) int 
{
	if 1 > n || n > 1000 return;

    total := (n * (n + 1)) / 2
    sum := 0
        
    for i := 1; i <= n; i++ {
        sum += i;
            
        if(sum == (total - sum + i)) {
            return i;
        }
    }

    return -1;
}