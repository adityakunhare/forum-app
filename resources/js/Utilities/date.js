import { formatDistance, parseISO } from 'date-fns';

let relativeDate = (givenDate) => formatDistance(parseISO(givenDate), new Date());

export {
	relativeDate
}