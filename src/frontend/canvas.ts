import * as THREE from "three";

/**
 * ThreeJS City Canvas.
 */
export default class Canvas
{
	public renderer = new THREE.WebGLRenderer({ antialias: true });
	public camera = new THREE.PerspectiveCamera(25, window.innerWidth / window.innerHeight, 1, 500);

	public scene = new THREE.Scene();
	public city = new THREE.Object3D();
	public town = new THREE.Object3D();

	public createCarPos = true;
	public uSpeed = 0.001;
	public setcolor = 0x0023ff;

	public ambientLight = new THREE.AmbientLight(0xFFFFFF, 4);
	public lightFront = new THREE.SpotLight(0xFFFFFF, 20, 10);
	public lightBack = new THREE.PointLight(0xFFFFFF, 0.5);
	public spotLightHelper = new THREE.SpotLightHelper(this.lightFront);

	public gridHelper = new THREE.GridHelper(60, 120, 0x0000FF, 0x000000);

	/**
	 * Initialize a new background scene.
	 */
	public constructor()
	{
		this.renderer.setSize(window.innerWidth, window.innerHeight);

		// enable shadow maps
		if (window.innerWidth > 800) 
		{
			this.renderer.shadowMap.enabled = true;
			this.renderer.shadowMap.type = THREE.PCFSoftShadowMap;
			this.renderer.shadowMap.needsUpdate = true;
		}

		// render & resize event
		document.body.appendChild(this.renderer.domElement);
		window.addEventListener("resize", this.onWindowResize.bind(this), false);

		this.camera.position.set(0, 7, 15);

		// scene bg & fog
		this.scene.background = new THREE.Color(this.setcolor);
		this.scene.fog = new THREE.Fog(this.setcolor, 10, 24);

		// light
		this.lightFront.rotation.x = 45 * Math.PI / 180;
		this.lightFront.rotation.z = -45 * Math.PI / 180;
		this.lightFront.position.set(5, 5, 5);
		this.lightFront.castShadow = true;
		this.lightFront.shadow.mapSize.width = 6000;
		this.lightFront.shadow.mapSize.height = this.lightFront.shadow.mapSize.width;
		this.lightFront.penumbra = 0.1;
		this.lightBack.position.set(0,6,0);

		// elements
		this.scene.add(this.ambientLight);
		this.city.add(this.lightFront);
		this.scene.add(this.lightBack);
		this.scene.add(this.city);
		this.city.add(this.town);
		this.city.add(this.gridHelper);

		// animate
		this.generateLines();
		this.init();
		this.animate();
	}

	/**
	 * Init geometries & effects.
	 */
	public init(): void
	{
		const segments = 2;
		for (let i = 1; i < 100; i++) 
		{
			const geometry = new THREE.BoxGeometry(1, 1, 1, segments, segments, segments);
			const material = new THREE.MeshStandardMaterial({
				color: 0x000000,
				wireframe: false,
				side: THREE.DoubleSide
			});
			const wmaterial = new THREE.MeshLambertMaterial({
				color: 0xFFFFFF,
				wireframe: true,
				transparent: true,
				opacity: 0.03,
				side: THREE.DoubleSide
			});

			const cube = new THREE.Mesh(geometry, material);
			const floor = new THREE.Mesh(geometry, material);
			const wfloor = new THREE.Mesh(geometry, wmaterial);
		
			cube.add(wfloor);
			cube.castShadow = true;
			cube.receiveShadow = true;
		
			floor.scale.y = 0.05;
			cube.scale.y = 0.1 + Math.abs(mathRandom(8));

			const cubeWidth = 0.9;
			cube.scale.x = cube.scale.z = cubeWidth + mathRandom(1-cubeWidth);
			cube.position.x = Math.round(mathRandom());
			cube.position.z = Math.round(mathRandom());
		
			floor.position.set(cube.position.x, 0, cube.position.z);
		
			this.town.add(floor);
			this.town.add(cube);
		}
	
		const pmaterial = new THREE.MeshPhongMaterial({
			color: 0x000000,
			side: THREE.DoubleSide,
			opacity: 0.9,
			transparent:true
		});
		const pgeometry = new THREE.PlaneGeometry(60,60);
		const pelement = new THREE.Mesh(pgeometry, pmaterial);
		pelement.rotation.x = -90 * Math.PI / 180;
		pelement.position.y = -0.001;
		pelement.receiveShadow = true;

		this.city.add(pelement);
	}

	/**
	 * On window resize callback.
	 */
	public onWindowResize(): void
	{
		this.camera.aspect = window.innerWidth / window.innerHeight;
		this.camera.updateProjectionMatrix();
		this.renderer.setSize(window.innerWidth, window.innerHeight);
	}

	/**
	 * Generate moving lines FXs.
	 */
	public generateLines(): void
	{
		for (let i = 0; i < 60; i++)
			this.createLine(0.1, 20);
	}

	/**
	 * Create an FX line.
	 * @param cScale - Line scale.
	 * @param cPos - Line pos.
	 * @param cColor - Line color.
	 */
	public createLine(cScale = 2, cPos = 20, cColor = 0xFFFF00): void
	{
		const cMat = new THREE.MeshToonMaterial({ color:cColor, side:THREE.DoubleSide });
		const cGeo = new THREE.BoxGeometry(1, cScale/40, cScale/40);
		const cElem = new THREE.Mesh(cGeo, cMat);
		const cAmp = 3;
	
		if (this.createCarPos) 
		{
			this.createCarPos = false;
			cElem.position.x = -cPos;
			cElem.position.z = (mathRandom(cAmp));
		} 
		else 
		{
			this.createCarPos = true;
			cElem.position.x = (mathRandom(cAmp));
			cElem.position.z = -cPos;
			cElem.rotation.y = 90 * Math.PI / 180;
		}
		cElem.receiveShadow = true;
		cElem.castShadow = true;
		cElem.position.y = Math.abs(mathRandom(5));
		this.city.add(cElem);
	}

	/**
	 * Render every frame.
	 */
	public frame(): void
	{
		setTimeout(() => 
		{
			requestAnimationFrame(this.animate.bind(this));

			// rotate the scene
			this.city.rotation.y -= this.uSpeed;
			for (let i = 0, l = this.town.children.length; i < l; i++)
				this.town.children[i];
		
			this.camera.lookAt(this.city.position);
		}, 1000 / 30);
	}

	/**
	 * Render callback.
	 */
	public animate(): void
	{
		this.frame();
		this.renderer.render(this.scene, this.camera); 
	}
}

/**
 * Get random value.
 * @param num - Multiplier value.
 */
export const mathRandom = (num = 8): number =>
{
	return -Math.random() * num + Math.random() * num;
};
