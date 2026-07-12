export interface ProcessCardProps {
  id: string;
  title: string;
  description: string;
  parity: string;
}

export const process: ProcessCardProps[] = [
  {
    id: "1",
    title: "Choisissez votre produit",
    description:
      "Parcourez notre catalogue et sélectionnez les articles parfaits",
    parity: "odd",
  },
  {
    id: "2",
    title: "Personnalisez avec votre logo",
    description: "Téléchargez votre logo et choisissez les couleurs",
    parity: "even",
  },
  {
    id: "3",
    title: "Validez le design",
    description: "Vérifiez et approuvez votre personnalisation",
    parity: "odd",
  },
  {
    id: "4",
    title: "Production & livraison",
    description: "Nous produisons et livrons à votre adresse",
    parity: "even",
  },
];
