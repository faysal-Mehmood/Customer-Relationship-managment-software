<?php
/**
 *     Class for General purpose methods
**/

class Gen 
{
    // Properties

    // Methods
    public function __construct() {
    }

    public function nameField($field, $siteSettings) {       // Use the alternate name across site
        switch ($field) {
            case 'customField' :
            $name = $siteSettings->customField1;
            break;
            case 'customField2':
            $name = $siteSettings->customField2;
            break;
            case 'customField3':
            $name = $siteSettings->customField3;
            break;
            case 'customField4' :
            $name = $siteSettings->customField4;
            break;
            case 'customField5':
            $name = $siteSettings->customField5;
            break;
            case 'customField6':
            $name = $siteSettings->customField6;
            break;
            case 'customField7':
            $name = $siteSettings->customField7;
            break;

            case 'customField8' :
                $name = $siteSettings->customField8;
                break;
                case 'customField9':
                $name = $siteSettings->customField9;
                break;
                case 'customField10':
                $name = $siteSettings->customField10;
                break;
                case 'customField11' :
                $name = $siteSettings->customField11;
                break;
                case 'customField12':
                $name = $siteSettings->customField12;
                break;
                case 'customField13':
                $name = $siteSettings->customField13;
                break;
                case 'customField14':
                $name = $siteSettings->customField14;
                break;
                case 'customField15':
                    $name = $siteSettings->customField15;
                    break;
                    case 'customField16':
                    $name = $siteSettings->customField16;
                    break;


                    case 'customField17' :
                        $name = $siteSettings->customField17;
                        break;
                        case 'customField18':
                        $name = $siteSettings->customField18;
                        break;
                        case 'customField19':
                        $name = $siteSettings->customField19;
                        break;
                        case 'customField20' :
                        $name = $siteSettings->customField20;
                        break;
                        case 'customField21':
                        $name = $siteSettings->customField21;
                        break;
                        case 'customField22':
                        $name = $siteSettings->customField22;
                        break;
                        case 'customField23':
                        $name = $siteSettings->customField23;
                        break;
            
                        case 'customField24' :
                            $name = $siteSettings->customField24;
                            break;
                            case 'customField25':
                            $name = $siteSettings->customField25;
                            break;
                            case 'customField26':
                            $name = $siteSettings->customField26;
                            break;
                            case 'customField27' :
                            $name = $siteSettings->customField27;
                            break;
                            case 'customField28':
                            $name = $siteSettings->customField28;
                            break;
                            case 'customField29':
                            $name = $siteSettings->customField29;
                            break;
                            case 'customField30':
                            $name = $siteSettings->customField30;
                            break;
                            case 'customField31':
                                $name = $siteSettings->customField31;
                                break;
                                case 'customField32':
                                $name = $siteSettings->customField32;
                                break;


                                case 'customField33' :
                                    $name = $siteSettings->customField33;
                                    break;
                                    case 'customField34':
                                    $name = $siteSettings->customField34;
                                    break;
                                    case 'customField35':
                                    $name = $siteSettings->customField35;
                                    break;
                                    case 'customField36' :
                                    $name = $siteSettings->customField36;
                                    break;
                                    case 'customField37':
                                    $name = $siteSettings->customField37;
                                    break;
                                    case 'customField38':
                                    $name = $siteSettings->customField38;
                                    break;
                                    case 'customField39':
                                    $name = $siteSettings->customField39;
                                    break;
                        
                                    case 'customField40' :
                                        $name = $siteSettings->customField40;
                                        break;
                                        case 'customField41':
                                        $name = $siteSettings->customField41;
                                        break;
                                        case 'customField42':
                                        $name = $siteSettings->customField42;
                                        break;
                                        case 'customField43' :
                                        $name = $siteSettings->customField43;
                                        break;
                                        case 'customField44':
                                        $name = $siteSettings->customField44;
                                        break;
                                        case 'customField45':
                                        $name = $siteSettings->customField45;
                                        break;
                                        case 'customField46':
                                        $name = $siteSettings->customField46;
                                        break;
                                        case 'customField47':
                                            $name = $siteSettings->customField47;
                                            break;
                                            case 'customField48':
                                            $name = $siteSettings->customField48;
                                            break;
                        
                        
                                            case 'customField49' :
                                                $name = $siteSettings->customField49;
                                                break;
                                                case 'customField50':
                                                $name = $siteSettings->customField50;
                                                break;
                                                case 'customField51':
                                                $name = $siteSettings->customField51;
                                                break;
                                                case 'customField52' :
                                                $name = $siteSettings->customField52;
                                                break;
                                                case 'customField53':
                                                $name = $siteSettings->customField53;
                                                break;
                                                case 'customField54':
                                                $name = $siteSettings->customField54;
                                                break;
                                                case 'customField55':
                                                $name = $siteSettings->customField55;
                                                break;
                                    
                                                case 'customField56' :
                                                    $name = $siteSettings->customField56;
                                                    break;
                                                    case 'customField57':
                                                    $name = $siteSettings->customField57;
                                                    break;
                                                    case 'customField58':
                                                    $name = $siteSettings->customField58;
                                                    break;
                                                    case 'customField59' :
                                                    $name = $siteSettings->customField59;
                                                    break;
                                                    case 'customField60':
                                                    $name = $siteSettings->customField60;
                                                    break;
                                                    case 'customField61':
                                                    $name = $siteSettings->customField61;
                                                    break;
                                                    case 'customField62':
                                                    $name = $siteSettings->customField62;
                                                    break;
                                                    case 'customField63':
                                                        $name = $siteSettings->customField63;
                                                        break;
                                                        case 'customField64':
                                                        $name = $siteSettings->customField64;
                                                        break;

            case 'Address':
            $name = $siteSettings->Address;
            break;
            case 'enddate':
            $name = $siteSettings->enddate;
            break;
            case 'weightage':
            $name = $siteSettings->weightage;
            break;
            case 'marksobtained':
            $name = $siteSettings->marksobtained;
            break;
            case 'totalmarks':
            $name = $siteSettings->totalmarks;
            break;
            case 'Phone':
            $name = $siteSettings->Phone;
            break;
            case 'subject':
            $name = $siteSettings->subject;
            break;
            case 'startdate':
            $name = $siteSettings->startdate;
            break;
            case 'assignedTo':
            $name = 'Owner';
            break;
            default:
            $name = $field;
        }
        return $name;
    }
}
