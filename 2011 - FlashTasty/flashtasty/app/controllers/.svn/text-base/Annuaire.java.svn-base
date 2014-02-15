package controllers;

import java.util.List;

import play.mvc.Controller;

import models.Cepage;
import models.Domaine;
import models.Vignoble;
import models.Vin;

public class Annuaire extends Controller {

	public static void index() {
		render();
	}




	public static void vins() {
		List<Vin> liste = Vin.findAll();
		boolean rechercher = true;

		render(liste, rechercher);
	}




	public static void domaines() {
		List<Domaine> liste = Domaine.findAll();
		render(liste);
	}
	public static void domainesVins(Long id) {
		Domaine domaine = Domaine.findById(id);
		notFoundIfNull(domaine);

		List<Vin> liste = Vin.find("byDomaine", domaine).fetch();
		String parent = domaine.nom;

		render("Annuaire/vins.html", liste, parent);
	}




	public static void vignobles() {
		List<Vignoble> liste = Vignoble.findAll();
		render(liste);
	}
	public static void vignoblesVins(Long id) {
		Vignoble vignoble = Vignoble.findById(id);
		notFoundIfNull(vignoble);

		List<Vin> liste = Vin.find("select v from Vin v, Domaine d where v.domaine = d and d.vignoble = ?", vignoble).fetch();
		String parent = vignoble.nom;

		render("Annuaire/vins.html", liste, parent);
	}




	public static void cepages() {
		List<Cepage> liste = Cepage.findAll();
		render(liste);
	}
	public static void cepagesVins(Long id) {
		Cepage cepage = Cepage.findById(id);
		notFoundIfNull(cepage);

		List<Vin> liste = cepage.vins;
		String parent = cepage.nom;

		render("Annuaire/vins.html", liste, parent);
	}

}
