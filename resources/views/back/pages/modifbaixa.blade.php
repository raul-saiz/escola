@extends('back.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'AddGuardia')
@section('content')

    <form action="{{ request()->route()->uri }}" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <table>
            <tr>
                <td>NOM : </td>
                @if (isset($data['profe'] ))
                <td><label type='text' name='profe'> {{ $data['profe']  }} </label></td>
                <input type="hidden" name="profe" value={{$data['profe']  }}>
                @else
                <td><label type='text' name='profe'> {{ $data['profe']  }} </label></td>
                <input type="hidden" name="profe" value={{ $data['profe']  }}>
                @endif
            </tr>
            <tr>
                <td>
                <label>Data inici : </label>
            </td>
            <td>
                @if (isset( $data['datain'] ))
                 <input class="form-control mb-2" type='text' placeholder="Select a date" name='in' id="datepicker-icon-prepend"  value={{$data['datain']  }}>
                 @else
                 <input class="form-control mb-2" type='text' placeholder="Select a date" name='in' id="datepicker-icon-prepend"  value={{ now() }}>
                 @endif
                </td>
            </tr>
            <tr>
                <td>
                    <label>Data fi : </label>
                </td>
                    <td>
                        @if (isset( $data['dataout'] ))
                     <input class="form-control mb-2" type='text' placeholder="Select a date" name='out'  id="datepicker-default" value={{ $data['dataout'] }}>
                     @else
                     <input class="form-control mb-2" type='text' placeholder="Select a date" name='out'  id="datepicker-default" value={{ now() }}>
                     @endif
                </td>
            </tr>
            <tr>
                <td>
                    <label>Tasca : </label>
                </td>
                    <td>
                        @if (isset( $data['tasca'] ))

                        <select class="form-select" id="tasca" name="tasca" > <option value="Moodle" selected="Moodle" >Moodle</option><option value="Prefectura" >Prefectura</option></select>
                     @else
                     <select class="form-select" id="tasca" name="tasca" > <option value="Moodle" selected="Moodle" >Moodle</option><option value="Prefectura" >Prefectura</option></select>
                     @endif
                </td>
            </tr>


            <tr>
                <td colspan='2'>
                    <input type='submit' value="Introdueix Absència" name="add"/>
                </td>
            </tr>

            <tr>
                <td colspan='2'>
                    <input type='submit' value="Esborrar Absència" name="delete"/>
                </td>
            </tr>
            <tr> <td>
                </td>
            </tr>
            <tr>  <td>
            </td></tr>
            <tr>
                <td>NOM COMPLET ( Cognom Cognom , Nom ): </td>

                <td><input  name="newprofe" >
                    <input type="hidden" name="profe" value={{ $data['profe']  }}>
                </td>


            </tr>
            <tr>
                <td>MAIL ID ( SENSE @XTEC.CAT): </td>

                <td><input  name="mail" ></td>


            </tr>
            <tr>
                <td colspan='2'>
                    <input type='submit' value="Canvi de Profe" name="chg"/>
                </td>
            </tr>
        </table>


    </form>

    <script src="./dist/libs/litepicker/dist/litepicker.js?1674944402" defer=""></script>
    <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function () {
            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-default'),
                buttonText: {
                    previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));
        });
        // @formatter:on
      </script>

      <script>
        // @formatter:off
        document.addEventListener("DOMContentLoaded", function () {
            window.Litepicker && (new Litepicker({
                element: document.getElementById('datepicker-icon'),
                buttonText: {
                    previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));
        });
        // @formatter:on
      </script>

<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
    	window.Litepicker && (new Litepicker({
    		element: document.getElementById('datepicker-icon-prepend'),
    		buttonText: {
    			previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
    			nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
    		},
    	}));
    });
    // @formatter:on
  </script>

<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
    	window.Litepicker && (new Litepicker({
    		element: document.getElementById('datepicker-inline'),
    		buttonText: {
    			previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
    			nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
    		},
    		inlineMode: true,
    	}));
    });
    // @formatter:on
  </script>
  <div class="litepicker" data-plugins="" style="display: none; position: absolute; z-index: 9999; top: 1939.42px; left: 866.156px;"><div class="container__main"><div class="container__months"><div class="month-item"><div class="month-item-header"><button type="button" class="button-previous-month"><!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M15 6l-6 6l6 6"></path></svg></button><div><strong class="month-item-name">June</strong><span class="month-item-year">2020</span></div><button type="button" class="button-next-month"><!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l6 6l-6 6"></path></svg></button></div><div class="month-item-weekdays-row"><div title="Monday">Mon</div><div title="Tuesday">Tue</div><div title="Wednesday">Wed</div><div title="Thursday">Thu</div><div title="Friday">Fri</div><div title="Saturday">Sat</div><div title="Sunday">Sun</div></div><div class="container__days"><div class="day-item" data-time="1590962400000" tabindex="0">1</div><div class="day-item" data-time="1591048800000" tabindex="0">2</div><div class="day-item" data-time="1591135200000" tabindex="0">3</div><div class="day-item" data-time="1591221600000" tabindex="0">4</div><div class="day-item" data-time="1591308000000" tabindex="0">5</div><div class="day-item" data-time="1591394400000" tabindex="0">6</div><div class="day-item" data-time="1591480800000" tabindex="0">7</div><div class="day-item" data-time="1591567200000" tabindex="0">8</div><div class="day-item" data-time="1591653600000" tabindex="0">9</div><div class="day-item" data-time="1591740000000" tabindex="0">10</div><div class="day-item" data-time="1591826400000" tabindex="0">11</div><div class="day-item" data-time="1591912800000" tabindex="0">12</div><div class="day-item" data-time="1591999200000" tabindex="0">13</div><div class="day-item" data-time="1592085600000" tabindex="0">14</div><div class="day-item" data-time="1592172000000" tabindex="0">15</div><div class="day-item" data-time="1592258400000" tabindex="0">16</div><div class="day-item" data-time="1592344800000" tabindex="0">17</div><div class="day-item" data-time="1592431200000" tabindex="0">18</div><div class="day-item" data-time="1592517600000" tabindex="0">19</div><div class="day-item is-start-date is-end-date" data-time="1592604000000" tabindex="0">20</div><div class="day-item" data-time="1592690400000" tabindex="0">21</div><div class="day-item" data-time="1592776800000" tabindex="0">22</div><div class="day-item" data-time="1592863200000" tabindex="0">23</div><div class="day-item" data-time="1592949600000" tabindex="0">24</div><div class="day-item" data-time="1593036000000" tabindex="0">25</div><div class="day-item" data-time="1593122400000" tabindex="0">26</div><div class="day-item" data-time="1593208800000" tabindex="0">27</div><div class="day-item" data-time="1593295200000" tabindex="0">28</div><div class="day-item" data-time="1593381600000" tabindex="0">29</div><div class="day-item" data-time="1593468000000" tabindex="0">30</div></div></div></div></div><div class="container__tooltip"></div></div>
    <div class="litepicker" data-plugins="" style="display: none; position: absolute; z-index: 9999; top: 1983.42px; left: 866.156px;"><div class="container__main"><div class="container__months"><div class="month-item"><div class="month-item-header"><button type="button" class="button-previous-month"><!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M15 6l-6 6l6 6"></path></svg></button><div><strong class="month-item-name">June</strong><span class="month-item-year">2020</span></div><button type="button" class="button-next-month"><!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l6 6l-6 6"></path></svg></button></div><div class="month-item-weekdays-row"><div title="Monday">Mon</div><div title="Tuesday">Tue</div><div title="Wednesday">Wed</div><div title="Thursday">Thu</div><div title="Friday">Fri</div><div title="Saturday">Sat</div><div title="Sunday">Sun</div></div><div class="container__days"><div class="day-item" data-time="1590962400000" tabindex="0">1</div><div class="day-item" data-time="1591048800000" tabindex="0">2</div><div class="day-item" data-time="1591135200000" tabindex="0">3</div><div class="day-item" data-time="1591221600000" tabindex="0">4</div><div class="day-item" data-time="1591308000000" tabindex="0">5</div><div class="day-item" data-time="1591394400000" tabindex="0">6</div><div class="day-item" data-time="1591480800000" tabindex="0">7</div><div class="day-item" data-time="1591567200000" tabindex="0">8</div><div class="day-item" data-time="1591653600000" tabindex="0">9</div><div class="day-item" data-time="1591740000000" tabindex="0">10</div><div class="day-item" data-time="1591826400000" tabindex="0">11</div><div class="day-item" data-time="1591912800000" tabindex="0">12</div><div class="day-item" data-time="1591999200000" tabindex="0">13</div><div class="day-item" data-time="1592085600000" tabindex="0">14</div><div class="day-item" data-time="1592172000000" tabindex="0">15</div><div class="day-item" data-time="1592258400000" tabindex="0">16</div><div class="day-item is-start-date is-end-date" data-time="1592344800000" tabindex="0">17</div><div class="day-item" data-time="1592431200000" tabindex="0">18</div><div class="day-item" data-time="1592517600000" tabindex="0">19</div><div class="day-item" data-time="1592604000000" tabindex="0">20</div><div class="day-item" data-time="1592690400000" tabindex="0">21</div><div class="day-item" data-time="1592776800000" tabindex="0">22</div><div class="day-item" data-time="1592863200000" tabindex="0">23</div><div class="day-item" data-time="1592949600000" tabindex="0">24</div><div class="day-item" data-time="1593036000000" tabindex="0">25</div><div class="day-item" data-time="1593122400000" tabindex="0">26</div><div class="day-item" data-time="1593208800000" tabindex="0">27</div><div class="day-item" data-time="1593295200000" tabindex="0">28</div><div class="day-item" data-time="1593381600000" tabindex="0">29</div><div class="day-item" data-time="1593468000000" tabindex="0">30</div></div></div></div></div><div class="container__tooltip"></div></div>
        <div class="litepicker" data-plugins="" style="display: none;"><div class="container__main"><div class="container__months"><div class="month-item"><div class="month-item-header"><button type="button" class="button-previous-month"><!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M15 6l-6 6l6 6"></path></svg></button><div><strong class="month-item-name">June</strong><span class="month-item-year">2020</span></div><button type="button" class="button-next-month"><!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l6 6l-6 6"></path></svg></button></div><div class="month-item-weekdays-row"><div title="Monday">Mon</div><div title="Tuesday">Tue</div><div title="Wednesday">Wed</div><div title="Thursday">Thu</div><div title="Friday">Fri</div><div title="Saturday">Sat</div><div title="Sunday">Sun</div></div><div class="container__days"><div class="day-item" data-time="1590962400000" tabindex="0">1</div><div class="day-item" data-time="1591048800000" tabindex="0">2</div><div class="day-item" data-time="1591135200000" tabindex="0">3</div><div class="day-item" data-time="1591221600000" tabindex="0">4</div><div class="day-item" data-time="1591308000000" tabindex="0">5</div><div class="day-item" data-time="1591394400000" tabindex="0">6</div><div class="day-item" data-time="1591480800000" tabindex="0">7</div><div class="day-item" data-time="1591567200000" tabindex="0">8</div><div class="day-item" data-time="1591653600000" tabindex="0">9</div><div class="day-item" data-time="1591740000000" tabindex="0">10</div><div class="day-item" data-time="1591826400000" tabindex="0">11</div><div class="day-item" data-time="1591912800000" tabindex="0">12</div><div class="day-item" data-time="1591999200000" tabindex="0">13</div><div class="day-item" data-time="1592085600000" tabindex="0">14</div><div class="day-item" data-time="1592172000000" tabindex="0">15</div><div class="day-item" data-time="1592258400000" tabindex="0">16</div><div class="day-item" data-time="1592344800000" tabindex="0">17</div><div class="day-item" data-time="1592431200000" tabindex="0">18</div><div class="day-item" data-time="1592517600000" tabindex="0">19</div><div class="day-item is-start-date is-end-date" data-time="1592604000000" tabindex="0">20</div><div class="day-item" data-time="1592690400000" tabindex="0">21</div><div class="day-item" data-time="1592776800000" tabindex="0">22</div><div class="day-item" data-time="1592863200000" tabindex="0">23</div><div class="day-item" data-time="1592949600000" tabindex="0">24</div><div class="day-item" data-time="1593036000000" tabindex="0">25</div><div class="day-item" data-time="1593122400000" tabindex="0">26</div><div class="day-item" data-time="1593208800000" tabindex="0">27</div><div class="day-item" data-time="1593295200000" tabindex="0">28</div><div class="day-item" data-time="1593381600000" tabindex="0">29</div><div class="day-item" data-time="1593468000000" tabindex="0">30</div></div></div></div></div><div class="container__tooltip"></div></div>
@endsection
