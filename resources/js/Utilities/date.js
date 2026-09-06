import { formatDistance, parseISO } from 'date-fns';

let relativeDate = (givenDate) => formatDistance(
									parseISO(givenDate), 
									new Date(),
									{ addSuffix: true }
								);

export {
	relativeDate
}