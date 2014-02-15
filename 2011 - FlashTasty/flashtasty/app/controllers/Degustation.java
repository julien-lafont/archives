package controllers;

import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import helpers.PhotoHelper;

import org.hamcrest.core.IsNull;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;

import models.Domaine;
import models.Vin;
import play.Logger;
import play.i18n.Messages;
import play.libs.I18N;
import play.mvc.Before;
import play.mvc.Controller;
import play.mvc.Router;
import play.mvc.Scope.Session;
import play.mvc.With;
import utils.VinsUtils;

@With(Bootstrap.class)
public class Degustation extends Controller {


	public static void fiche(Long idVin) {
		Vin vin = Vin.findById(idVin);
		notFoundIfNull(vin);

		VinsUtils.ajouterVin(vin);

		render(vin);
	}

	public static void dernierVins() {
		ArrayList<Vin> liste = VinsUtils.listeDernierVins(5);
		render(liste);
	}

	public static void popupEtiquette(Long idVin) {
		Vin vin = Vin.findById(idVin);
		notFoundIfNull(vin);

		String pageId 	= "photoEtiquette-"+vin.id;
		String titre 	= Messages.get("Etiquette")+"<br />"+vin.nom;

		Map map = new HashMap<String, Object>();
		map .put("id", vin.id);
		String src		= Router.reverse("Photo.photoVin", map).url;

		renderTemplate("Degustation/dialog-photo.html", pageId, titre, src);
	}

	public static void popupDomaine(Long idDomaine) {
		Domaine domaine = Domaine.findById(idDomaine);
		notFoundIfNull(domaine);

		String pageId 	= "photoDomaine-"+domaine.id;
		String titre 	= Messages.get("Domaine")+"<br />"+domaine.nom;

		Map map = new HashMap<String, Object>();
		map.put("id", domaine.id);
		String src		= Router.reverse("Photo.photoDomaine", map).url;

		renderTemplate("Degustation/dialog-photo.html", pageId, titre, src);
	}

	public static void popupProducteur(Long idDomaine) {
		Domaine domaine = Domaine.findById(idDomaine);
		notFoundIfNull(domaine);

		String pageId 	= "photoProducteur-"+domaine.id;
		String titre 	= Messages.get("Producteur")+"<br />"+domaine.nomProducteur;

		Map map = new HashMap<String, Object>();
		map.put("id", domaine.id);
		String src		= Router.reverse("Photo.photoProducteur", map).url;

		renderTemplate("Degustation/dialog-photo.html", pageId, titre, src);
	}

	public static void popupInsolite(Long idDomaine) {
		Domaine domaine = Domaine.findById(idDomaine);
		notFoundIfNull(domaine);

		String pageId 	= "photoInsolite-"+domaine.id;
		String titre 	= Messages.get("Insolite");

		Map map = new HashMap<String, Object>();
		map.put("id", domaine.id);
		String src		= Router.reverse("Photo.photoInsolite", map).url;

		renderTemplate("Degustation/dialog-photo.html", pageId, titre, src);
	}

	public static void popupAdresse(Long idDomaine, String type) {
		Domaine domaine = Domaine.findById(idDomaine);
		notFoundIfNull(domaine);

		String adresse, adresseBrute;
		if ("domaine".equals(type)) {

			adresse = String.format("<p><strong>%s</strong></p><p>%s</p><p>Tel : %s</p><p>Email : %s</p>",
						domaine.nom, domaine.adresseDomaine, domaine.telephone, domaine.email);
			adresseBrute = domaine.adresseDomaine;
		} else {
			adresse = String.format("<p><strong>%s</strong></p><p>%s</p>", Messages.get("PointDeVente"), domaine.adressePtVente);
			if (!domaine.telephone.isEmpty()) adresse += String.format("%s : <a href=\"tel:%s\">%s</a><br />",  Messages.get("Tel"), domaine.telephone, domaine.telephone);
			if (!domaine.email.isEmpty()) adresse += String.format("%s : <a href=\"mailto:%s\">%s</a><br />",  Messages.get("Email"), domaine.email, domaine.email);
			adresseBrute = domaine.adressePtVente;
		}

		adresseBrute = adresseBrute.replaceAll("(\n|\t|\r)", " ");
		adresseBrute += " France";

		renderTemplate("Degustation/dialog-adresse.html", adresse, adresseBrute);
	}

	public static void popupAdresseGMap(String adresse /*Long idDomaine, String type*/) {
		/*Domaine domaine = Domaine.findById(idDomaine);
		notFoundIfNull(domaine);

		String adresse = ("domaine".equals(type)) ? domaine.adresseDomaine : domaine.adressePtVente;*/

		renderTemplate("Degustation/dialog-adresse-gmap.html", adresse);

	}

}
