<?php class CoachController{
function dashboard(){requireRole('coach');$stats=['activities'=>db()->query('SELECT COUNT(*) FROM activities WHERE active=1')->fetchColumn(),'sessions'=>db()->query('SELECT COUNT(*) FROM sessions WHERE starts_at>NOW()')->fetchColumn(),'reservations'=>db()->query("SELECT COUNT(*) FROM reservations WHERE status='confirmed'")->fetchColumn()];view('coach/dashboard',compact('stats'));}
function activities(){requireRole('coach');require_once __DIR__.'/../models/Activity.php';$activities=Activity::allAdmin();$categories=Activity::categories();view('coach/activities',compact('activities','categories'));}
function saveActivity(){requireRole('coach');check_csrf();require_once __DIR__.'/../models/Activity.php';Activity::save($_POST,!empty($_POST['id'])?(int)$_POST['id']:null);flash('success','Activité enregistrée.');redirect('/coach/activites');}
function toggleActivity(){requireRole('coach');check_csrf();require_once __DIR__.'/../models/Activity.php';Activity::toggle((int)$_POST['id']);redirect('/coach/activites');}
function sessions(){requireRole('coach');require_once __DIR__.'/../models/Activity.php';$activities=Activity::allAdmin();$sessions=Activity::upcomingSessions();view('coach/sessions',compact('activities','sessions'));}
function addSession(){requireRole('coach');check_csrf();require_once __DIR__.'/../models/Activity.php';Activity::addSession($_POST);flash('success','Séance programmée.');redirect('/coach/seances');}
function deleteSession(){requireRole('coach');check_csrf();require_once __DIR__.'/../models/Activity.php';Activity::deleteSession((int)$_POST['id']);redirect('/coach/seances');}
function reservations(){requireRole('coach');require_once __DIR__.'/../models/Reservation.php';$items=Reservation::all();view('coach/reservations',compact('items'));}
function reservationStatus(){requireRole('coach');check_csrf();require_once __DIR__.'/../models/Reservation.php';Reservation::setStatus((int)$_POST['id'],$_POST['status']);redirect('/coach/reservations');}
function reviews(){requireRole('coach');require_once __DIR__.'/../models/Review.php';$items=Review::all();view('coach/reviews',compact('items'));}
function reviewStatus(){requireRole('coach');check_csrf();require_once __DIR__.'/../models/Review.php';Review::moderate((int)$_POST['id'],$_POST['status']);redirect('/coach/avis');}
function contacts(){requireRole('coach');require_once __DIR__.'/../models/Contact.php';$items=Contact::all();view('coach/contacts',compact('items'));}
function contactProcessed(){requireRole('coach');check_csrf();require_once __DIR__.'/../models/Contact.php';Contact::processed((int)$_POST['id']);redirect('/coach/contacts');}
}