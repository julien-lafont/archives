package controllers;

import helpers.PhotoHelper;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.InputStream;

import models.*;
import play.Logger;
import play.Play;
import play.cache.Cache;
import play.cache.CacheFor;
import play.db.jpa.Blob;
import play.libs.IO;
import play.mvc.Before;
import play.mvc.Catch;
import play.mvc.Controller;
import utils.ConfigUtil;
import utils.ImageUtil;

public class Photo extends Controller {

	private static PhotoHelper photoHelper = new PhotoHelper();

	private static final int VIGNETTE_W = ConfigUtil.getInt("vignette.width", 80);
	private static final int VIGNETTE_H = ConfigUtil.getInt("vignette.height", 80);



	public static void photoVin(long id) {
		Vin vin = Vin.findById(id); notFoundIfNull(vin);

		response.setContentTypeIfNotSet(vin.photoEtiquette.type());
		renderBinary(vin.photoEtiquette.get());
	}

	public static void photoVinVignette(long id) {
		Vin vin = Vin.findById(id); notFoundIfNull(vin);

		response.setContentTypeIfNotSet(vin.photoEtiquette.type());
		renderBinary(getPhotoRedimCache(vin.photoEtiquette, VIGNETTE_W, VIGNETTE_H));
	}



	public static void photoDomaine(long id) {
		Domaine domaine = Domaine.findById(id); notFoundIfNull(domaine);

		response.setContentTypeIfNotSet(domaine.photoDomaine.type());
		renderBinary(domaine.photoDomaine.get());
	}

	public static void photoDomaineVignette(long id) {
		Domaine domaine = Domaine.findById(id); notFoundIfNull(domaine);

		response.setContentTypeIfNotSet(domaine.photoDomaine.type());
		renderBinary(getPhotoRedimCache(domaine.photoDomaine, VIGNETTE_W, VIGNETTE_H));
	}



	public static void photoProducteur(long id) {
		Domaine domaine = Domaine.findById(id);
		notFoundIfNull(domaine);
		response.setContentTypeIfNotSet(domaine.photoProducteur.type());
		renderBinary(domaine.photoProducteur.get());
	}

	public static void photoProducteurVignette(long id) {
		Domaine domaine = Domaine.findById(id);
		notFoundIfNull(domaine);
		response.setContentTypeIfNotSet(domaine.photoProducteur.type());
		renderBinary(getPhotoRedimCache(domaine.photoProducteur, VIGNETTE_W, -1));
	}



	public static void photoInsolite(long id) {
		Domaine domaine = Domaine.findById(id);
		notFoundIfNull(domaine);
		response.setContentTypeIfNotSet(domaine.photoInsolite.type());
		renderBinary(domaine.photoInsolite.get());
	}

	public static void photoInsoliteVignette(long id) {
		Domaine domaine = Domaine.findById(id);
		notFoundIfNull(domaine);
		response.setContentTypeIfNotSet(domaine.photoInsolite.type());
		renderBinary(getPhotoRedimCache(domaine.photoInsolite, VIGNETTE_W, -1));
	}



	private static InputStream getPhotoRedimCache(Blob photo, int w, int h) {

		String key = photo.getFile().getName()+ "_" + w + "_" + h;						// Clé identifiant la miniature
		String destPath = Play.tmpDir+File.separator+key+photoHelper.extension(photo);	// Chemin du fichier mis en cache
		File fileOutput = new File(destPath);

		// Cas où on met en cache
		if (fileOutput == null || !fileOutput.isFile() || !fileOutput.canRead()) {

			fileOutput = new File(Play.tmpDir+File.separator+key+photoHelper.extension(photo));
			ImageUtil.resize(photo, fileOutput, w, h);

			Logger.debug("Creation de la miniature enregistree dans " + fileOutput.getPath());

		// On récupère le fichier du cache
		} else {
			fileOutput = new File(destPath);

			Logger.debug("Recuperation de la miniature en cache " + fileOutput.getPath());
		}

		// Tranforme et retourne le fichier en flux
		try {
			return new FileInputStream(fileOutput);
		} catch (FileNotFoundException e) {
			Logger.error("Impossible de recuperer le flux de l'image reduite");
			return photo.get();	// Fallback sur l'image d'origine
		}

	}








}
