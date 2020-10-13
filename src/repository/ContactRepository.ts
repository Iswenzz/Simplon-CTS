import Axios from "axios";
import Repository from "./Repository";
import {Pays} from "./PaysRepository";
import ResponseAPI from "./ResponseAPI";

export interface Contact extends ResponseAPI
{
	code: number,
	nom: string,
	prenom: string,
	dateNaissance: string,
	pays: Pays
}

export default class ContactRepository implements Repository
{
	/**
	 * Get all contact.
	 */
	public async getAll() : Promise<Contact[]>
	{
		const response =  await Axios.post("${process.env.BACKEND_URL}/api/ContactAPI.php", {
			method: "getAll"
		});
		console.log(response.data);
		return response.data;
	}

	/**
	 * Get a contact.
	 * @param model
	 */
	public async get(model: Contact) : Promise<Contact>
	{
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/ContactAPI.php`, {
			method: "get",
			code: model.code
		});
		return response.data;
	}

	/**
	 * Add a contact.
	 * @param contact
	 */
	public async add(contact: Contact) : Promise<boolean>
	{
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/ContactAPI.php`, {
			method: "add",
			contact: contact
		});
		return response.data.success;
	}

	/**
	 * Delete a contact.
	 * @param contact
	 */
	public async delete(contact: Contact) : Promise<boolean>
	{
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/ContactAPI.php`, {
			method: "delete",
			contact: contact
		});
		return response.data.success;
	}

	/**
	 * Update a contact.
	 * @param contact
	 */
	public async update(contact: Contact) : Promise<boolean>
	{
		const response =  await Axios.post(`${process.env.BACKEND_URL}/server/src/api/ContactAPI.php`, {
			method: "update",
			contact: contact
		});
		return response.data.success;
	}
}