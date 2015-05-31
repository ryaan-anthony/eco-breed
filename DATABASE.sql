

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `pw` varchar(50) NOT NULL,
  `reset` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=185 ;

-- --------------------------------------------------------

--
-- Table structure for table `action_rules`
--

CREATE TABLE IF NOT EXISTS `action_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `species_index` int(11) NOT NULL,
  `Configuration_Name` varchar(250) NOT NULL,
  `Configuration_ID` varchar(50) NOT NULL,
  `Actions` longtext NOT NULL,
  `Text_String` varchar(500) NOT NULL DEFAULT 'eco.action v%Version%',
  `Show_Text` int(1) NOT NULL DEFAULT '0',
  `Text_Color` varchar(250) NOT NULL DEFAULT '<0.3, 0.9, 0.5>',
  `Activation_Param` int(11) NOT NULL DEFAULT '0',
  `Version` varchar(10) NOT NULL DEFAULT '1.0',
  `Self_Destruct` int(1) NOT NULL DEFAULT '0',
  `Owner_Only` int(1) NOT NULL DEFAULT '1',
  `Touch_Events` int(1) NOT NULL DEFAULT '0',
  `Limit_Requests` int(11) NOT NULL DEFAULT '200',
  `Action_Type` varchar(250) NOT NULL,
  `Breed_Limit` int(11) NOT NULL DEFAULT '-1',
  `Breed_Timeout` int(11) NOT NULL DEFAULT '60',
  `Desc_Filter` varchar(250) NOT NULL,
  `Allow_Breeding` int(1) NOT NULL DEFAULT '0',
  `Limit_Rezzed` int(11) NOT NULL DEFAULT '-1',
  `Breed_Maxed_Die` int(1) NOT NULL DEFAULT '0',
  `Breed_One_Family` int(1) NOT NULL DEFAULT '0',
  `Breed_Object` varchar(250) NOT NULL,
  `Food_Level` int(11) NOT NULL DEFAULT '0',
  `Food_Quality` int(11) NOT NULL DEFAULT '1',
  `Food_Threshold` int(11) NOT NULL DEFAULT '0',
  `Reserve_Food` int(1) NOT NULL DEFAULT '0',
  `Allow_Rebuild` int(1) NOT NULL DEFAULT '0',
  `Rebuild_Max` int(11) NOT NULL DEFAULT '10',
  `Status` int(1) NOT NULL DEFAULT '1',
  `Dead_Breeds` int(1) NOT NULL DEFAULT '0',
  `Rebuild_Object` varchar(250) NOT NULL,
  `Touch_Length` int(11) NOT NULL DEFAULT '2',
  `Message` varchar(250) NOT NULL DEFAULT '\\nSelect a breed:',
  `Button_Next` varchar(50) NOT NULL DEFAULT 'NEXT',
  `Button_Prev` varchar(50) NOT NULL DEFAULT 'PREV',
  `Confirm_Message` varchar(250) NOT NULL DEFAULT '\\nAre you sure?',
  `Button_Confirm` varchar(50) NOT NULL DEFAULT 'Yes',
  `Button_Cancel` varchar(50) NOT NULL DEFAULT 'Cancel',
  `Radius` float NOT NULL DEFAULT '0.5',
  `Height` float NOT NULL DEFAULT '0',
  `Offset` varchar(250) NOT NULL DEFAULT '<0,0,0>',
  `Rot` varchar(250) NOT NULL DEFAULT '<0,0,0>',
  `Pattern` int(11) NOT NULL DEFAULT '6',
  `Arc` float NOT NULL DEFAULT '1',
  `last_update` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=266 ;

-- --------------------------------------------------------

--
-- Table structure for table `anims`
--

CREATE TABLE IF NOT EXISTS `anims` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anim_name` varchar(250) NOT NULL,
  `anim_repeat` int(11) NOT NULL,
  `anim_delay` float NOT NULL,
  `anim_params` longtext NOT NULL,
  `anim_frames` int(11) NOT NULL,
  `anim_species` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=398 ;

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE IF NOT EXISTS `api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(250) NOT NULL,
  `expire` int(20) NOT NULL,
  `user` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `api_dev`
--

CREATE TABLE IF NOT EXISTS `api_dev` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_key` varchar(250) NOT NULL,
  `total_requests` int(11) NOT NULL DEFAULT '0',
  `recent_time` int(11) NOT NULL DEFAULT '0',
  `recent_count` mediumint(11) NOT NULL DEFAULT '0',
  `throttle_count` int(11) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Table structure for table `api_execution`
--

CREATE TABLE IF NOT EXISTS `api_execution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exec_time` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `authorized_user`
--

CREATE TABLE IF NOT EXISTS `authorized_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `species_index` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

-- --------------------------------------------------------

--
-- Table structure for table `breed`
--

CREATE TABLE IF NOT EXISTS `breed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_name` varchar(250) NOT NULL,
  `owner_id` varchar(50) NOT NULL,
  `breed_id` varchar(250) NOT NULL,
  `breed_name` varchar(250) NOT NULL,
  `breed_gender` varchar(50) NOT NULL,
  `breed_born` int(11) NOT NULL,
  `breed_dead` int(11) NOT NULL,
  `breed_age` int(11) NOT NULL,
  `breed_species` varchar(250) NOT NULL DEFAULT 'Unknown Species',
  `breed_skins` longtext NOT NULL,
  `breed_hunger` int(11) NOT NULL,
  `breed_parents` longtext NOT NULL,
  `breed_generation` int(11) NOT NULL,
  `timer_breed` int(11) NOT NULL,
  `timer_age` int(11) NOT NULL,
  `timer_grow` int(11) NOT NULL,
  `timer_hunger` int(11) NOT NULL,
  `breed_key` varchar(250) NOT NULL,
  `breed_update` varchar(250) NOT NULL,
  `breed_chan` varchar(50) NOT NULL,
  `breed_creator` varchar(250) NOT NULL,
  `breed_pos` varchar(250) NOT NULL,
  `breed_region` varchar(250) NOT NULL,
  `breed_notdead` int(11) NOT NULL,
  `breed_litters` int(11) NOT NULL,
  `breed_anims` longtext NOT NULL,
  `breed_growth_total` varchar(250) NOT NULL,
  `growth_stages` int(11) NOT NULL,
  `breed_physics` int(11) NOT NULL,
  `breed_version` varchar(50) NOT NULL,
  `breed_partner` varchar(250) NOT NULL,
  `web_update` int(1) NOT NULL DEFAULT '0',
  `breed_globals` longtext NOT NULL,
  `breed_cached` longtext,
  `partner_timeout` int(11) NOT NULL DEFAULT '0',
  `pregnancy_timeout` int(11) NOT NULL DEFAULT '0',
  `debug_this` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=521803 ;

-- --------------------------------------------------------

--
-- Table structure for table `breed_rules`
--

CREATE TABLE IF NOT EXISTS `breed_rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `species_index` int(11) NOT NULL,
  `Configuration_Name` varchar(250) NOT NULL,
  `Configuration_ID` varchar(50) NOT NULL,
  `Globals` longtext NOT NULL,
  `Activation_Param` int(11) NOT NULL DEFAULT '1',
  `Lineage_Selection` int(1) NOT NULL DEFAULT '3',
  `Lineage_Globals` longtext NOT NULL,
  `Allow_Throttling` int(1) NOT NULL DEFAULT '0',
  `Sync_Timeout` int(11) NOT NULL DEFAULT '0',
  `Retry_Timeout` int(11) NOT NULL DEFAULT '20',
  `Allowed_Types` longtext NOT NULL,
  `Self_Destruct` int(1) NOT NULL DEFAULT '0',
  `Owner_Only` int(1) NOT NULL DEFAULT '1',
  `Limit_Requests` int(11) NOT NULL DEFAULT '200',
  `Name_Generator` int(1) NOT NULL DEFAULT '0',
  `Gender_Specific` int(1) NOT NULL DEFAULT '1',
  `Name_Object` varchar(250) NOT NULL DEFAULT 'eco.%name%',
  `Lifespan` int(1) NOT NULL DEFAULT '0',
  `Year` int(11) NOT NULL DEFAULT '1440',
  `Age_Start` int(11) NOT NULL DEFAULT '0',
  `Age_Min` int(11) NOT NULL DEFAULT '50',
  `Age_Max` int(11) NOT NULL DEFAULT '100',
  `Survival_Odds` int(11) NOT NULL DEFAULT '-1',
  `Growth_Stages` int(11) NOT NULL DEFAULT '0',
  `Growth_Timescale` int(11) NOT NULL DEFAULT '1440',
  `Growth_Scale` float NOT NULL DEFAULT '1.05',
  `Growth_Odds` int(3) NOT NULL DEFAULT '0',
  `Hunger_Timescale` int(11) NOT NULL DEFAULT '0',
  `Hunger_Start` int(3) NOT NULL DEFAULT '40',
  `Hunger_Odds` int(3) NOT NULL DEFAULT '0',
  `Hunger_Min` int(3) NOT NULL DEFAULT '1',
  `Hunger_Max` int(3) NOT NULL DEFAULT '5',
  `Hunger_Lost` int(3) NOT NULL DEFAULT '1',
  `Starvation_Threshold` int(3) NOT NULL DEFAULT '10',
  `Starvation_Odds` int(3) NOT NULL DEFAULT '-1',
  `Genders` int(1) NOT NULL DEFAULT '0',
  `Gender_Ratio` int(11) NOT NULL DEFAULT '1',
  `Gender_Male` varchar(250) NOT NULL DEFAULT 'Male',
  `Gender_Female` varchar(250) NOT NULL DEFAULT 'Female',
  `Gender_Unisex` varchar(250) NOT NULL DEFAULT 'None',
  `Breed_Time` int(1) NOT NULL DEFAULT '0',
  `Litter_Min` int(11) NOT NULL DEFAULT '1',
  `Litter_Max` int(11) NOT NULL DEFAULT '3',
  `Litter_Rare` int(1) NOT NULL DEFAULT '0',
  `Litters` int(11) NOT NULL DEFAULT '-1',
  `Breed_Age_Min` int(11) NOT NULL DEFAULT '0',
  `Breed_Age_Max` int(11) NOT NULL DEFAULT '-1',
  `Breed_Failed_Odds` int(3) NOT NULL DEFAULT '0',
  `Pregnancy_Timeout` int(11) NOT NULL DEFAULT '0',
  `Select_Generation` int(1) NOT NULL DEFAULT '1',
  `Require_Partners` int(1) NOT NULL DEFAULT '1',
  `Unique_Partner` int(1) NOT NULL DEFAULT '1',
  `Keep_Partners` int(1) NOT NULL DEFAULT '1',
  `Partner_Timeout` int(11) NOT NULL DEFAULT '0',
  `Skins` int(1) NOT NULL DEFAULT '0',
  `Skins_Min` int(11) NOT NULL DEFAULT '1',
  `Skins_Max` int(11) NOT NULL DEFAULT '2',
  `Preserve_Lineage` int(1) NOT NULL DEFAULT '1',
  `Preferred_Skins` longtext NOT NULL,
  `Sound_Volume` float NOT NULL DEFAULT '1',
  `Sit_Pos` varchar(250) NOT NULL DEFAULT '<0,0,0.5>',
  `Sit_Rot` varchar(250) NOT NULL DEFAULT '<0,0,0>',
  `Sit_Adjust` int(1) NOT NULL DEFAULT '1',
  `Cam_Pos` varchar(250) NOT NULL DEFAULT '<-2,0,1>',
  `Cam_Look` varchar(250) NOT NULL DEFAULT '<2,0,1>',
  `Cam_Adjust` int(1) NOT NULL DEFAULT '1',
  `Text_Prim` int(3) NOT NULL DEFAULT '0',
  `Text_Color` varchar(250) NOT NULL DEFAULT '<0.3,0.9,0.5>',
  `Text_Alpha` float NOT NULL DEFAULT '1',
  `Loading_Text` varchar(250) NOT NULL,
  `Undefined_Value` varchar(250) NOT NULL DEFAULT 'Undefined',
  `Pause_Anims` int(1) NOT NULL DEFAULT '1',
  `Pause_Move` int(1) NOT NULL DEFAULT '1',
  `Pause_Core` int(1) NOT NULL DEFAULT '1',
  `Pause_Action` int(1) NOT NULL DEFAULT '1',
  `Prim_Material` int(2) NOT NULL DEFAULT '4',
  `Slope_Offset` float NOT NULL DEFAULT '0.5',
  `Move_Timer` float NOT NULL DEFAULT '1.2',
  `Finish_Move` int(1) NOT NULL DEFAULT '0',
  `Target_Dist_Min` float NOT NULL DEFAULT '2',
  `Water_Timeout` int(11) NOT NULL DEFAULT '5',
  `Move_Attempts` int(11) NOT NULL DEFAULT '-1',
  `Allow_Drift` int(1) NOT NULL DEFAULT '0',
  `Anim_Each_Move` int(1) NOT NULL DEFAULT '0',
  `End_Move_Physics` int(1) NOT NULL DEFAULT '0',
  `Legacy_Prims` int(1) NOT NULL DEFAULT '1',
  `Ground_Friction` float NOT NULL DEFAULT '0.2',
  `Turning_Speed` float NOT NULL DEFAULT '0.2',
  `Turning_Time` float NOT NULL DEFAULT '0.2',
  `Speed_setpos` float NOT NULL DEFAULT '0.7',
  `Speed_nonphys` float NOT NULL DEFAULT '3.5',
  `Speed_nonphysUp` float NOT NULL DEFAULT '3.5',
  `Speed_walk` float NOT NULL DEFAULT '4',
  `Gravity_walk` float NOT NULL DEFAULT '0.8',
  `Speed_run` float NOT NULL DEFAULT '8',
  `Gravity_run` float NOT NULL DEFAULT '0.8',
  `Speed_jump` float NOT NULL DEFAULT '15',
  `Gravity_jump` float NOT NULL DEFAULT '0',
  `Speed_swim` float NOT NULL DEFAULT '5',
  `Gravity_swim` float NOT NULL DEFAULT '0',
  `Speed_hop` float NOT NULL DEFAULT '8',
  `Gravity_hop` float NOT NULL DEFAULT '0',
  `Speed_hover` float NOT NULL DEFAULT '2',
  `Gravity_hover` float NOT NULL DEFAULT '0',
  `Speed_fly` float NOT NULL DEFAULT '5.5',
  `Gravity_fly` float NOT NULL DEFAULT '0',
  `Speed_float` float NOT NULL DEFAULT '3.5',
  `Gravity_float` float NOT NULL DEFAULT '0',
  `Prefix` longtext NOT NULL,
  `Middle` longtext NOT NULL,
  `Male_Suffix` longtext NOT NULL,
  `Female_Suffix` longtext NOT NULL,
  `last_update` int(15) NOT NULL,
  `Growth_Offset` float NOT NULL DEFAULT '0.4',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=259 ;

-- --------------------------------------------------------

--
-- Table structure for table `cached_results`
--

CREATE TABLE IF NOT EXISTS `cached_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(250) NOT NULL,
  `params` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=259722 ;

-- --------------------------------------------------------

--
-- Table structure for table `chamber`
--

CREATE TABLE IF NOT EXISTS `chamber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `breeds` longtext NOT NULL,
  `owner` varchar(250) NOT NULL,
  `chamber_id` varchar(50) NOT NULL,
  `cached` longtext NOT NULL,
  `channel` int(20) NOT NULL,
  `creator` varchar(250) NOT NULL,
  `food` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cleanup`
--

CREATE TABLE IF NOT EXISTS `cleanup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `inactive_remove` int(15) NOT NULL DEFAULT '0',
  `dead_remove` int(15) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `eco_creators`
--

CREATE TABLE IF NOT EXISTS `eco_creators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `version` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

-- --------------------------------------------------------

--
-- Table structure for table `error_log`
--

CREATE TABLE IF NOT EXISTS `error_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` longtext NOT NULL,
  `type` varchar(250) NOT NULL,
  `user` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48159 ;

-- --------------------------------------------------------

--
-- Table structure for table `rebuild`
--

CREATE TABLE IF NOT EXISTS `rebuild` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `breed_id` varchar(250) NOT NULL,
  `breed_chan` int(50) NOT NULL,
  `owner_name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=216 ;

-- --------------------------------------------------------

--
-- Table structure for table `skins`
--

CREATE TABLE IF NOT EXISTS `skins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `skin_name` varchar(250) NOT NULL,
  `skin_category` varchar(250) NOT NULL,
  `skin_gen` int(11) NOT NULL,
  `skin_odds` int(11) NOT NULL,
  `skin_params` longtext NOT NULL,
  `skin_limit` int(11) NOT NULL,
  `skin_species` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1591 ;

-- --------------------------------------------------------

--
-- Table structure for table `species`
--

CREATE TABLE IF NOT EXISTS `species` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `species_name` varchar(250) NOT NULL,
  `species_chan` varchar(16) NOT NULL,
  `species_creator` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=703 ;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_time` int(11) NOT NULL,
  `sub_type` int(1) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=254 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `uuid` varchar(250) NOT NULL,
  `version` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=88 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
