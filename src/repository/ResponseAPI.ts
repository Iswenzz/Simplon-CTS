import Model from "./Model";

/**
 * Default API ResponseAPI
 */
export default interface ResponseAPI<T extends Model | Model[]>
{
	success?: boolean,
	body: T,
	error?: string
}
