export function dateToString(date) {
	if (typeof date == "string")
		date = new Date(date);

	return date.toLocaleString();
}
