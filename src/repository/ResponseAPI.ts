/**
 * Default API ResponseAPI
 */
import Model from "./Model";

export default interface ResponseAPI<T extends Model>
{
	success?: boolean,
	body: T,
	error?: string
}
