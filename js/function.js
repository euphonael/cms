function int(amount)
{
	var i = parseInt(amount);
	if (isNaN(i)) i = 0;
	return i;
}