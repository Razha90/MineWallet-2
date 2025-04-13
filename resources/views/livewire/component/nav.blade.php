<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="fixed bottom-0 max-w-full w-full border-t border-gray-500/20 bg-white py-3 shadow-2xl" x-data="load">
    <div class="flex flex-row max-w-xl justify-around mx-auto">
        <div @click="if (path !== '/') { NProgress.start(); window.location = '/'; NProgress.done(); }"
            class="flex cursor-pointer flex-col items-center justify-center rounded-md px-4 py-2 transition-all"
            x-bind:class="{
                'bg-blue-300/15': path === '/',
                'bg-white hover:bg-black/10': path !== '/'
            }">
            <svg class="w-[25px] stroke-current" :class="path === '/' ? 'text-blue-500' : 'text-gray-500'"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <path
                        d="M22 12.2V13.7C22 17.6 22 19.5 20.8 20.8C19.6 22 17.8 22 14 22H10C6.2 22 4.3 22 3.1 20.8C2 19.5 2 17.6 2 13.7V12.2C2 9.9 2 8.7 2.5 7.8C3 6.8 4 6.2 5.9 5.1L7.9 3.8C9.9 2.6 10.9 2 12 2C13.1 2 14.1 2.6 16.1 3.8L18.1 5.1C20 6.2 21 6.8 21.5 7.8"
                        stroke-width="1.5" stroke-linecap="round"></path>
                    <path d="M15 18H9" stroke-width="1.5" stroke-linecap="round"></path>
                </g>
            </svg>
            <p class="text-sm"
                x-bind:class="{
                    'text-blue-500': path === '/',
                    'text-gray-500': path !== '/'
                }">
                Home</p>
        </div>
        <div @click="if (path !== '/transaction') { NProgress.start(); window.location = '/transaction'; NProgress.done(); }"
            class="flex cursor-pointer flex-col items-center justify-center rounded-md px-4 py-2 transition-all"
            x-bind:class="{
                'bg-blue-300/15': path === '/transaction',
                'bg-white hover:bg-black/10': path !== '/transaction'
            }">

            <svg class="w-[25px] stroke-current" :class="path === '/transaction' ? 'text-blue-500' : 'text-gray-500'"
                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M8 2V5" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                    <path d="M16 2V5" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                    <path
                        d="M21 8.5V17C21 20 19.5 22 16 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z"
                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path opacity="0.4" d="M8 11H16" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                    <path opacity="0.4" d="M8 16H12" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                        stroke-linejoin="round"></path>
                </g>
            </svg>
            <p class="text-sm"
                x-bind:class="{
                    'text-blue-500': path === '/transaction',
                    'text-gray-500': path !== '/transaction'
                }">
                Mutasi</p>
        </div>
        <div @click="if (path !== '/profile') { NProgress.start(); window.location = '/profile'; NProgress.done(); }"
            class="flex cursor-pointer flex-col items-center justify-center rounded-md px-4 py-2 transition-all"
            x-bind:class="{
                'bg-blue-300/15': path === '/profile',
                'bg-white hover:bg-black/10': path !== '/profile'
            }">

            <svg class="w-[25px] stroke-current" :class="path === '/profile' ? 'text-blue-500' : 'text-gray-500'"
                viewBox="0 0 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentColor">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <title>profile_round [#1346]</title>
                    <desc>Created with Sketch.</desc>
                    <defs> </defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
                        <g id="Dribbble-Light-Preview" transform="translate(-380.000000, -2119.000000)" fill="currentColor">
                            <g id="icons" transform="translate(56.000000, 160.000000)">
                                <path
                                    d="M338.083123,1964.99998 C338.083123,1962.79398 336.251842,1960.99998 334,1960.99998 C331.748158,1960.99998 329.916877,1962.79398 329.916877,1964.99998 C329.916877,1967.20599 331.748158,1968.99999 334,1968.99999 C336.251842,1968.99999 338.083123,1967.20599 338.083123,1964.99998 M341.945758,1979 L340.124685,1979 C339.561214,1979 339.103904,1978.552 339.103904,1978 C339.103904,1977.448 339.561214,1977 340.124685,1977 L340.5626,1977 C341.26898,1977 341.790599,1976.303 341.523154,1975.662 C340.286989,1972.69799 337.383888,1970.99999 334,1970.99999 C330.616112,1970.99999 327.713011,1972.69799 326.476846,1975.662 C326.209401,1976.303 326.73102,1977 327.4374,1977 L327.875315,1977 C328.438786,1977 328.896096,1977.448 328.896096,1978 C328.896096,1978.552 328.438786,1979 327.875315,1979 L326.054242,1979 C324.778266,1979 323.773818,1977.857 324.044325,1976.636 C324.787453,1973.27699 327.107688,1970.79799 330.163906,1969.67299 C328.769519,1968.57399 327.875315,1966.88999 327.875315,1964.99998 C327.875315,1961.44898 331.023403,1958.61898 334.733941,1959.04198 C337.422678,1959.34798 339.650022,1961.44698 340.05323,1964.06998 C340.400296,1966.33099 339.456073,1968.39599 337.836094,1969.67299 C340.892312,1970.79799 343.212547,1973.27699 343.955675,1976.636 C344.226182,1977.857 343.221734,1979 341.945758,1979 M337.062342,1978 C337.062342,1978.552 336.605033,1979 336.041562,1979 L331.958438,1979 C331.394967,1979 330.937658,1978.552 330.937658,1978 C330.937658,1977.448 331.394967,1977 331.958438,1977 L336.041562,1977 C336.605033,1977 337.062342,1977.448 337.062342,1978"
                                    id="profile_round-[#1346]"> </path>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
            <p class="text-sm"
                x-bind:class="{
                    'text-blue-500': path === '/profile',
                    'text-gray-500': path !== '/profile'
                }">
                Profil</p>
        </div>
    </div>
</div>
<script>
    function load() {
        return {
            path: window.location.pathname,
        }
    }
</script>