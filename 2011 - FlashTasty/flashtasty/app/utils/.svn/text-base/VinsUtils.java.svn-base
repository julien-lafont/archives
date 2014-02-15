package utils;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Queue;
import java.util.Stack;

import org.apache.commons.collections.ArrayStack;
import org.apache.commons.lang.ArrayUtils;

import play.mvc.Scope.Session;
import models.Vin;

public class VinsUtils {

	public static final int NB_VINS_MAX = 10;
	public static final String SESSION_VINS = "vins";

	/**
	 * Ajoute le vin en tête de la liste des vins visualisés par l'utilisation
	 * Valeur stockée en session (cookies)
	 * @param vin
	 */
	public static void  ajouterVin(Vin vin) {
		Stack<Long> pile = listeDernierVinsId();
		pile.remove(vin.id);
		pile.push(new Long(vin.id));
		getSession().put(SESSION_VINS, serialize(pile));
	}

	/**
	 * Retourne la liste des [NB_VINS_MAX] derniers id-vins visualisées par l'utilisateur
	 * @return
	 */
	public static Stack<Long> listeDernierVinsId() {
		if (!getSession().contains(SESSION_VINS)) {
			getSession().put(SESSION_VINS, "");
		}

		String listeSerialized = getSession().get(SESSION_VINS);
		return unserialize(listeSerialized);
	}

	public static ArrayList<Vin> listeDernierVins(int max) {
		Stack<Long> stack = listeDernierVinsId();
		ArrayList<Vin> listeVins = new ArrayList<Vin>();

		int nb=0;
		while (!stack.isEmpty() && nb<max) {
			long id = stack.pop();
			Vin vin = Vin.findById(id);
			listeVins.add(0, vin);
			nb++;
		}

		return listeVins;
	}


	private static String serialize(Stack<Long> stack) {
		StringBuffer sb = new StringBuffer();
		while (!stack.isEmpty()) {
			sb.append(stack.pop());
			if (!stack.isEmpty()) sb.append(";");
		}
		return sb.toString();
	}

	private static Stack<Long> unserialize(String str) {
		Stack<Long> stack = new Stack<Long>();
		String[] array = str.split(";");
		int size = str.length()>0 ? array.length : 0;	// 0 si string vide
		for (int i=size-1; i>=0;  i--) {
			stack.push(Long.parseLong(array[i]));
		}
		return stack;
	}

	private static Session getSession() {
		return Session.current();
	}

}
