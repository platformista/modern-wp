/**
 * For Filter courses with LP v4.1.6
 */
const formOrderBy = document.querySelector( '.thim-course-order select' );
let elSkeleton;
const urlCourses = typeof lpGlobalSettings !== 'undefined' ? lpGlobalSettings.courses_url || '' : lpData.courses_url;
let elArchive = null;

// Filter event
const formFilter = document.querySelector( 'form.thim-course-filter' );
if ( formFilter != null ) {
	formFilter.addEventListener( 'submit', async function( e ) {
		e.preventDefault();
		let filterCourses = JSON.parse(window.localStorage.getItem('lp_filter_courses')) || {};
		const filterFields = formFilter.querySelectorAll( '.thim-filter-sidebar-field' );
		let objFieldsTmp = { 'paged' : 1 };

		elArchive.scrollIntoView( { behavior: 'smooth' } );

		filterFields.forEach((value, key, parent) => {
			const nameField = value.getAttribute('name');
			const typeField = value.getAttribute('type');

			switch (typeField) {
				case 'checkbox':
					if (objFieldsTmp[nameField] === undefined) {
						objFieldsTmp[nameField] = [];
					}

					if(value.checked) {
						objFieldsTmp[nameField].push(value.value);
					}
					break;
				case 'radio':
				case 'select':
					if(value.checked) {
						objFieldsTmp[nameField] =  value.value;
					}
					break;
			}
		});

		const filterCoursesParams = { ...filterCourses, ...objFieldsTmp };

		if ( ! elSkeleton ) {
			filterCoursesParams.paged = 1;
			reloadPageWithParamsFilter( filterCoursesParams );
		} else {
			elSkeleton.style.display = 'block';
		}

		if ( window.lpCourseList ) {
			window.lpCourseList.updateEventTypeBeforeFetch( 'filter' );
			window.lpCourseList.triggerFetchAPI( {...filterCoursesParams} );
		}
	} );
}

function reloadPageWithParamsFilter( filterCoursesParams ) {
	let url = new URL( window.location.href );

	if ( filterCoursesParams[ 'paged' ] === 1 ) {
		url = new URL( urlCourses );
	}

	for ( let key in filterCoursesParams ) {
		if ( filterCoursesParams[ key ] != null ) {
			url.searchParams.set( key, filterCoursesParams[ key ] );
		}
	}

	url.searchParams.set( 'isPageLoad', 1 );

	window.location.href = url;
}

// Select option order by archive course
formOrderBy && formOrderBy.addEventListener( 'change', function() {
	const filterCourses = JSON.parse( window.localStorage.getItem('lp_filter_courses') ) || {};
	filterCourses.order_by = this.value || '';

	if ( ! elSkeleton ) {
		reloadPageWithParamsFilter(filterCourses);
	} else {
		elSkeleton.style.display = 'block';
	}

	if ( window.lpCourseList ) {
		window.lpCourseList.updateEventTypeBeforeFetch( 'filter' );
		window.lpCourseList.triggerFetchAPI( {...filterCourses} );
	}
} );

wp.hooks.addAction( 'lp-js-get-courses', 'lp', function ( response ) {
	const elCourseIndex = document.querySelector( '.course-index' );
	const elStickyHeader = document.querySelector( '.sticky-header' );

	if( elCourseIndex ) {
		const span = elCourseIndex.querySelector( 'span' );
		if( span && response.data.from_to !== undefined ) {
			span.innerHTML = response.data.from_to;
		}
	}

	if ( elStickyHeader ) {
		elStickyHeader.classList.add( 'menu-hidden' );
	}
})

document.addEventListener( 'DOMContentLoaded', function() {
	elArchive = document.querySelector( '.lp-archive-courses' );
	elSkeleton = document.querySelector( '.lp-archive-course-skeleton' );
	//elNoLoadAjaxFirst = document.querySelector( '.no-first-load-ajax' );
} );
